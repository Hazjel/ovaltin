<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesData;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class SalesDataController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data penjualan untuk tabel
        $salesHistory = SalesData::orderBy('tanggal_penjualan', 'desc')->paginate(20);
        
        $products = SalesData::getAvailableProducts();
        
        // Data untuk visualisasi per bulan
        $selectedYear = $request->get('year', now()->year);
        $selectedMonth = $request->get('month', null); // null berarti semua bulan
        $monthlyData = $this->getMonthlySalesData($selectedYear, $selectedMonth);
        
        // Ranking produk paling laku
        $topProducts = $this->getTopProducts();
        
        // Summary data
        $summary = $this->getSalesSummary();
        
        return view('sales-data.index', compact(
            'salesHistory',
            'products',
            'monthlyData',
            'topProducts',
            'summary',
            'selectedYear',
            'selectedMonth'
        ));
    }
    
    /**
     * Get monthly sales data for visualization
     */
    private function getMonthlySalesData($year, $selectedMonth = null)
    {
        // Jika bulan dipilih, hanya tampilkan data untuk bulan tersebut (per hari)
        if ($selectedMonth) {
            $startDate = Carbon::create($year, $selectedMonth, 1)->startOfMonth();
            $endDate = Carbon::create($year, $selectedMonth, 1)->endOfMonth();
            $daysInMonth = $endDate->daysInMonth;
            
            $monthlyData = collect(range(1, $daysInMonth))->map(function ($day) use ($year, $selectedMonth) {
                $date = Carbon::create($year, $selectedMonth, $day);
                
                $dailySales = SalesData::whereDate('tanggal_penjualan', $date->format('Y-m-d'))
                    ->select('nama_produk', DB::raw('SUM(jumlah_terjual) as total'))
                    ->groupBy('nama_produk')
                    ->get();
                
                $data = [];
                foreach ($dailySales as $sale) {
                    $data[$sale->nama_produk] = $sale->total;
                }
                
                return [
                    'date' => $date->format('d/m/Y'),
                    'day' => $day,
                    'data' => $data,
                ];
            });
            
            return [
                'type' => 'daily',
                'data' => $monthlyData->values(),
                'month_name' => Carbon::create($year, $selectedMonth, 1)->translatedFormat('F Y'),
            ];
        }
        
        // Jika tidak ada bulan yang dipilih, tampilkan semua bulan dalam tahun
        $months = collect(range(1, 12))->map(function ($month) use ($year) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            
            $monthlySales = SalesData::whereBetween('tanggal_penjualan', [$startDate, $endDate])
                ->select('nama_produk', DB::raw('SUM(jumlah_terjual) as total'))
                ->groupBy('nama_produk')
                ->get();
            
            $data = [];
            foreach ($monthlySales as $sale) {
                $data[$sale->nama_produk] = $sale->total;
            }
            
            return [
                'month' => $startDate->translatedFormat('M Y'),
                'month_num' => $month,
                'data' => $data,
            ];
        });
        
        return [
            'type' => 'monthly',
            'data' => $months->values(),
        ];
    }
    
    /**
     * Get top products ranking
     */
    private function getTopProducts()
    {
        return SalesData::select('nama_produk', DB::raw('SUM(jumlah_terjual) as total_terjual'))
            ->groupBy('nama_produk')
            ->orderBy('total_terjual', 'desc')
            ->get()
            ->map(function ($item, $index) {
                return [
                    'rank' => $index + 1,
                    'nama_produk' => $item->nama_produk,
                    'total_terjual' => $item->total_terjual,
                ];
            });
    }
    
    /**
     * Get sales summary
     */
    private function getSalesSummary()
    {
        $totalSales = SalesData::sum('jumlah_terjual');
        $totalTransactions = SalesData::count();
        $avgPerTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
        
        $products = SalesData::getAvailableProducts();
        $productSummary = [];
        
        foreach ($products as $product) {
            $productData = SalesData::where('nama_produk', $product)
                ->select(
                    DB::raw('SUM(jumlah_terjual) as total'),
                    DB::raw('AVG(jumlah_terjual) as avg'),
                    DB::raw('COUNT(*) as count')
                )
                ->first();
            
            $productSummary[$product] = [
                'total' => $productData->total ?? 0,
                'avg' => round($productData->avg ?? 0, 2),
                'count' => $productData->count ?? 0,
            ];
        }
        
        return [
            'total_sales' => $totalSales,
            'total_transactions' => $totalTransactions,
            'avg_per_transaction' => round($avgPerTransaction, 2),
            'products' => $productSummary,
        ];
    }
    
    /**
     * Generate sales performance report
     */
    public function generateReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $salesData = SalesData::whereBetween('tanggal_penjualan', [$startDate, $endDate])
            ->get();
        
        // Group by product
        $productData = $salesData->groupBy('nama_produk')->map(function ($items) {
            return [
                'total' => $items->sum('jumlah_terjual'),
                'count' => $items->count(),
                'avg' => $items->avg('jumlah_terjual'),
                'min' => $items->min('jumlah_terjual'),
                'max' => $items->max('jumlah_terjual'),
            ];
        });
        
        // Monthly breakdown
        $monthlyBreakdown = $salesData->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_penjualan)->format('Y-m');
        })->map(function ($items) {
            return [
                'total' => $items->sum('jumlah_terjual'),
                'count' => $items->count(),
            ];
        });
        
        return response()->json([
            'period' => [
                'start' => $startDate,
                'end' => $endDate,
            ],
            'summary' => [
                'total_sales' => $salesData->sum('jumlah_terjual'),
                'total_transactions' => $salesData->count(),
                'avg_per_transaction' => round($salesData->avg('jumlah_terjual'), 2),
            ],
            'products' => $productData,
            'monthly_breakdown' => $monthlyBreakdown,
        ]);
    }

    /**
     * Download sales performance report as Excel
     */
    public function downloadReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $salesData = SalesData::whereBetween('tanggal_penjualan', [$startDate, $endDate])
            ->orderBy('tanggal_penjualan', 'asc')
            ->get();
        
        // Group by product
        $productData = $salesData->groupBy('nama_produk')->map(function ($items) {
            return [
                'total' => $items->sum('jumlah_terjual'),
                'count' => $items->count(),
                'avg' => $items->avg('jumlah_terjual'),
                'min' => $items->min('jumlah_terjual'),
                'max' => $items->max('jumlah_terjual'),
            ];
        });
        
        // Monthly breakdown
        $monthlyBreakdown = $salesData->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_penjualan)->format('Y-m');
        })->map(function ($items) {
                            return [
                'total' => $items->sum('jumlah_terjual'),
                'count' => $items->count(),
            ];
        });
        
        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set title
        $sheet->setTitle('Laporan Performa Penjualan');
        
        // Header
        $sheet->setCellValue('A1', 'LAPORAN PERFORMA PENJUALAN');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('A2', 'Periode: ' . Carbon::parse($startDate)->format('d/m/Y') . ' - ' . Carbon::parse($endDate)->format('d/m/Y'));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Summary
        $row = 4;
        $sheet->setCellValue('A' . $row, 'RINGKASAN');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(12);
        $row++;
        
        $sheet->setCellValue('A' . $row, 'Total Penjualan:');
        $sheet->setCellValue('B' . $row, $salesData->sum('jumlah_terjual'));
        $row++;
        
        $sheet->setCellValue('A' . $row, 'Total Transaksi:');
        $sheet->setCellValue('B' . $row, $salesData->count());
        $row++;
        
        $sheet->setCellValue('A' . $row, 'Rata-rata per Transaksi:');
        $sheet->setCellValue('B' . $row, round($salesData->avg('jumlah_terjual'), 2));
        $row += 2;
        
        // Per Produk
        $sheet->setCellValue('A' . $row, 'PER PRODUK');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(12);
        $row++;
        
        $sheet->setCellValue('A' . $row, 'Produk');
        $sheet->setCellValue('B' . $row, 'Total');
        $sheet->setCellValue('C' . $row, 'Transaksi');
        $sheet->setCellValue('D' . $row, 'Rata-rata');
        $sheet->setCellValue('E' . $row, 'Min');
        $sheet->setCellValue('F' . $row, 'Max');
        
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ];
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($headerStyle);
        $row++;
        
        foreach ($productData as $product => $stats) {
            $sheet->setCellValue('A' . $row, $product);
            $sheet->setCellValue('B' . $row, $stats['total']);
            $sheet->setCellValue('C' . $row, $stats['count']);
            $sheet->setCellValue('D' . $row, round($stats['avg'], 2));
            $sheet->setCellValue('E' . $row, $stats['min']);
            $sheet->setCellValue('F' . $row, $stats['max']);
            $row++;
        }
        
        $row += 2;
        
        // Breakdown Bulanan
        $sheet->setCellValue('A' . $row, 'BREAKDOWN BULANAN');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(12);
        $row++;
        
        $sheet->setCellValue('A' . $row, 'Bulan');
        $sheet->setCellValue('B' . $row, 'Total Penjualan');
        $sheet->setCellValue('C' . $row, 'Total Transaksi');
        $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($headerStyle);
        $row++;
        
        foreach ($monthlyBreakdown as $month => $stats) {
            $monthName = Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y');
            $sheet->setCellValue('A' . $row, $monthName);
            $sheet->setCellValue('B' . $row, $stats['total']);
            $sheet->setCellValue('C' . $row, $stats['count']);
            $row++;
        }
        
        $row += 2;
        
        // Detail Transaksi
        $sheet->setCellValue('A' . $row, 'DETAIL TRANSAKSI');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(12);
        $row++;
        
        $sheet->setCellValue('A' . $row, 'Tanggal');
        $sheet->setCellValue('B' . $row, 'Produk');
        $sheet->setCellValue('C' . $row, 'Jumlah Terjual');
        $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray($headerStyle);
        $row++;
        
        foreach ($salesData as $sale) {
            $sheet->setCellValue('A' . $row, Carbon::parse($sale->tanggal_penjualan)->format('d/m/Y'));
            $sheet->setCellValue('B' . $row, $sale->nama_produk);
            $sheet->setCellValue('C' . $row, $sale->jumlah_terjual);
            $row++;
        }
        
        // Auto size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Generate filename
        $filename = 'Laporan_Performa_Penjualan_' . Carbon::parse($startDate)->format('Ymd') . '_' . Carbon::parse($endDate)->format('Ymd') . '.xlsx';
        
        // Create writer
        $writer = new Xlsx($spreadsheet);
        
        // Return response with Excel file
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_penjualan' => 'required|date',
            'nama_produk' => 'required|string|in:' . implode(',', SalesData::getAvailableProducts()),
            'jumlah_terjual' => 'required|integer|min:0',
        ]);

        SalesData::create([
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'nama_produk' => $request->nama_produk,
            'jumlah_terjual' => $request->jumlah_terjual,
        ]);

        return redirect()->route('sales-data.index')->with('success', 'Data penjualan berhasil ditambahkan.');
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            if (count($rows) < 3) {
                return redirect()->route('sales-data.index')->with('error', 'File Excel kosong atau format tidak valid.');
            }

            // Struktur Excel: 
            // Baris 0: ["Tanggal ", "Produk", null, null, null, null, "Total", "Ket"]
            // Baris 1: [null, "agar", "dodol", "krupuk", "selai", "Sambel", null, null]
            // Baris 2+: Data penjualan
            
            // Cari header produk di baris kedua (index 1)
            $productHeaderRow = $rows[1] ?? [];
            $productColumns = [];
            
            // Cari kolom produk mulai dari kolom 1 (skip kolom 0 yang biasanya Tanggal)
            for ($col = 1; $col < count($productHeaderRow); $col++) {
                $headerValue = trim($productHeaderRow[$col] ?? '');
                if (!empty($headerValue)) {
                    // Normalisasi nama produk
                    $normalized = $this->normalizeProductName($headerValue);
                    if ($normalized) {
                        $productColumns[$col] = $normalized;
                    }
                }
            }

            if (empty($productColumns)) {
                return redirect()->route('sales-data.index')->with('error', 'Tidak ditemukan kolom produk di header.');
            }

            // Mulai dari baris ketiga (index 2) karena baris 0 dan 1 adalah header
            $importedCount = 0;
            $skippedCount = 0;
            $errors = [];

            DB::beginTransaction();

            try {
                for ($row = 2; $row < count($rows); $row++) {
                    $rowData = $rows[$row];
                    
                    // Kolom pertama adalah tanggal (index 0)
                    $tanggalValue = $rowData[0] ?? null;
                    
                    if (empty($tanggalValue)) {
                        continue;
                    }

                    // Coba ambil nilai langsung dari cell menggunakan koordinat Excel (A1, A2, dll)
                    // Column A = 1, row dimulai dari 1 (bukan 0)
                    $columnLetter = Coordinate::stringFromColumnIndex(1);
                    $cellCoordinate = $columnLetter . ($row + 1);
                    
                    try {
                        $cell = $worksheet->getCell($cellCoordinate);
                        $cellValue = $cell->getValue();
                        
                        // Jika cell adalah formula, ambil calculated value
                        if ($cell->getDataType() == DataType::TYPE_FORMULA) {
                            $cellValue = $cell->getCalculatedValue();
                        }
                        
                        // Jika cellValue kosong, gunakan nilai dari toArray()
                        if (empty($cellValue) && !empty($tanggalValue)) {
                            $cellValue = $tanggalValue;
                        }
                    } catch (\Exception $e) {
                        // Jika gagal, gunakan nilai dari toArray()
                        $cellValue = $tanggalValue;
                    }
                    
                    if (empty($cellValue)) {
                        continue;
                    }

                    // Parse tanggal
                    $tanggal = $this->parseDate($cellValue);
                    if (!$tanggal) {
                        $skippedCount++;
                        continue;
                    }

                    // Import data untuk setiap produk
                    foreach ($productColumns as $colIndex => $productName) {
                        $jumlahValue = $rowData[$colIndex] ?? null;
                        
                        if ($jumlahValue === null || $jumlahValue === '') {
                            continue;
                        }

                        // Konversi ke integer
                        $jumlah = $this->parseNumber($jumlahValue);
                        
                        if ($jumlah > 0) {
                            // Cek apakah data sudah ada (untuk menghindari duplikasi)
                            $exists = SalesData::where('tanggal_penjualan', $tanggal)
                                ->where('nama_produk', $productName)
                                ->exists();

                            if (!$exists) {
                                SalesData::create([
                                    'tanggal_penjualan' => $tanggal,
                                    'nama_produk' => $productName,
                                    'jumlah_terjual' => $jumlah,
                                ]);
                                $importedCount++;
                            }
                        }
                    }
                }

                DB::commit();

                $message = "Berhasil mengimpor {$importedCount} data penjualan.";
                if ($skippedCount > 0) {
                    $message .= " {$skippedCount} baris dilewati karena format tidak valid.";
                }

                return redirect()->route('sales-data.index')->with('success', $message);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('sales-data.index')->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            return redirect()->route('sales-data.index')->with('error', 'Gagal membaca file Excel: ' . $e->getMessage());
        }
    }

    /**
     * Normalisasi nama produk
     */
    private function normalizeProductName($name)
    {
        $name = strtolower(trim($name));
        $availableProducts = SalesData::getAvailableProducts();
        
        // Mapping nama produk
        $mapping = [
            'agar' => 'Agar',
            'dodol' => 'Dodol',
            'krupuk' => 'Krupuk',
            'selai' => 'Selai',
            'sambel' => 'Selai', // Sambel mungkin typo atau sama dengan selai
        ];

        if (isset($mapping[$name])) {
            return $mapping[$name];
        }

        // Cek apakah nama sudah sesuai dengan produk yang tersedia
        foreach ($availableProducts as $product) {
            if (strtolower($product) === $name) {
                return $product;
            }
        }

        return null;
    }

    /**
     * Parse tanggal dari berbagai format
     */
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // Jika sudah berupa Carbon/DateTime object
        if ($value instanceof \DateTime) {
            return Carbon::instance($value)->format('Y-m-d');
        }

        // Jika berupa numeric (Excel date serial number) - HARUS dicek SEBELUM string
        if (is_numeric($value)) {
            try {
                // Gunakan PhpSpreadsheet untuk convert Excel date
                $dateTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
                return Carbon::instance($dateTime)->format('Y-m-d');
            } catch (\Exception $e) {
                // Jika gagal, coba sebagai timestamp Unix
                try {
                    return Carbon::createFromTimestamp($value)->format('Y-m-d');
                } catch (\Exception $e2) {
                    return null;
                }
            }
        }

        // Jika berupa string
        if (is_string($value)) {
            $value = trim($value);
            
            // Coba format dd/mm/yyyy (format Indonesia/Excel)
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
                $day = (int)$matches[1];
                $month = (int)$matches[2];
                $year = (int)$matches[3];
                try {
                    return Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                } catch (\Exception $e) {
                    return null;
                }
            }

            // Coba format yyyy-mm-dd
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value, $matches)) {
                $year = (int)$matches[1];
                $month = (int)$matches[2];
                $day = (int)$matches[3];
                try {
                    return Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                } catch (\Exception $e) {
                    return null;
                }
            }

            // Coba parse dengan Carbon (untuk format lain)
            try {
                $parsed = Carbon::parse($value);
                return $parsed->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

    /**
     * Parse angka dari berbagai format
     */
    private function parseNumber($value)
    {
        if (is_numeric($value)) {
            return (int) $value;
        }

        if (is_string($value)) {
            // Hapus karakter non-numeric kecuali titik dan koma
            $cleaned = preg_replace('/[^0-9.,]/', '', $value);
            $cleaned = str_replace(',', '.', $cleaned);
            
            if (is_numeric($cleaned)) {
                return (int) floatval($cleaned);
            }
        }

        return 0;
    }


    public function edit($id)
    {
        $salesData = SalesData::findOrFail($id);
        $products = SalesData::getAvailableProducts();
        
            return response()->json([
            'id' => $salesData->id,
            'tanggal_penjualan' => $salesData->tanggal_penjualan->format('Y-m-d'),
            'nama_produk' => $salesData->nama_produk,
            'jumlah_terjual' => $salesData->jumlah_terjual,
            'products' => $products,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_penjualan' => 'required|date',
            'nama_produk' => 'required|string|in:' . implode(',', SalesData::getAvailableProducts()),
            'jumlah_terjual' => 'required|integer|min:0',
        ]);

        $salesData = SalesData::findOrFail($id);
        $salesData->update([
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'nama_produk' => $request->nama_produk,
            'jumlah_terjual' => $request->jumlah_terjual,
        ]);

        return redirect()->route('sales-data.index')->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $salesData = SalesData::findOrFail($id);
        $salesData->delete();

        return redirect()->route('sales-data.index')->with('success', 'Data penjualan berhasil dihapus.');
    }
}
