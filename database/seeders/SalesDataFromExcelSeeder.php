<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalesData;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesDataFromExcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path file Excel relatif dari root project
        $excelPath = base_path('../laravel/dataovaltin.xlsx');
        
        // Alternatif: jika file ada di folder laravel
        if (!file_exists($excelPath)) {
            $excelPath = base_path('../../laravel/dataovaltin.xlsx');
        }
        
        if (!file_exists($excelPath)) {
            $this->command->error("File Excel tidak ditemukan: {$excelPath}");
            return;
        }

        $this->command->info("Memulai import data dari: {$excelPath}");

        try {
            $spreadsheet = IOFactory::load($excelPath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            if (count($rows) < 2) {
                $this->command->error('File Excel kosong atau format tidak valid.');
                return;
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
                        $this->command->info("  - Kolom {$col}: '{$headerValue}' -> {$normalized}");
                    }
                }
            }

            if (empty($productColumns)) {
                $this->command->error('Tidak ditemukan kolom produk di header.');
                return;
            }

            // Mulai dari baris ketiga (index 2) karena baris 0 dan 1 adalah header
            $importedCount = 0;
            $skippedCount = 0;
            $duplicateCount = 0;

            DB::beginTransaction();

            try {
                for ($row = 2; $row < count($rows); $row++) {
                    $rowData = $rows[$row];
                    
                    // Kolom pertama adalah tanggal
                    $tanggalValue = $rowData[0] ?? null;
                    
                    if (empty($tanggalValue)) {
                        continue;
                    }

                    // Parse tanggal
                    $tanggal = $this->parseDate($tanggalValue);
                    if (!$tanggal) {
                        $skippedCount++;
                        $this->command->warn("  - Baris " . ($row + 1) . ": Tanggal tidak valid - {$tanggalValue}");
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
                            } else {
                                $duplicateCount++;
                            }
                        }
                    }
                }

                DB::commit();

                $this->command->info("\n=== Hasil Import ===");
                $this->command->info("✓ Berhasil mengimpor: {$importedCount} data penjualan");
                if ($duplicateCount > 0) {
                    $this->command->warn("⚠ Data duplikat (dilewati): {$duplicateCount}");
                }
                if ($skippedCount > 0) {
                    $this->command->warn("⚠ Baris dilewati (format tidak valid): {$skippedCount}");
                }

            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error('Gagal mengimpor data: ' . $e->getMessage());
                throw $e;
            }

        } catch (\Exception $e) {
            $this->command->error('Gagal membaca file Excel: ' . $e->getMessage());
            throw $e;
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

        // Jika berupa string
        if (is_string($value)) {
            $value = trim($value);
            
            // Coba format dd/mm/yyyy
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
                return Carbon::createFromDate($matches[3], $matches[2], $matches[1])->format('Y-m-d');
            }
            
            // Coba format yyyy-mm-dd
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value, $matches)) {
                return Carbon::createFromDate($matches[1], $matches[2], $matches[3])->format('Y-m-d');
            }
            
            // Coba parse dengan Carbon
            try {
                return Carbon::parse($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Jika berupa numeric (Excel date serial number)
        if (is_numeric($value)) {
            try {
                // Excel date adalah jumlah hari sejak 1900-01-01
                $excelBaseDate = Carbon::create(1900, 1, 1);
                // Excel memiliki bug: menganggap 1900 adalah tahun kabisat
                // Jadi kita perlu mengurangi 2 hari untuk tanggal setelah 28 Februari 1900
                $days = (int)$value - 2;
                return $excelBaseDate->addDays($days)->format('Y-m-d');
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
            return (int)$value;
        }

        if (is_string($value)) {
            // Hapus karakter non-numeric kecuali titik dan koma
            $cleaned = preg_replace('/[^0-9.,]/', '', $value);
            // Ganti koma dengan titik
            $cleaned = str_replace(',', '.', $cleaned);
            return (int)floatval($cleaned);
        }

        return 0;
    }
}
