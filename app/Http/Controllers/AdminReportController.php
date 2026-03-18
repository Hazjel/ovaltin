<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use App\Models\StrawberryProduct;
use App\Models\Testimonial;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    /**
     * Display the report configuration panel.
     */
    public function index(): View
    {
        $now = now();

        return view('admin.reports.index', [
            'defaultStart' => $now->copy()->startOfMonth()->toDateString(),
            'defaultEnd' => $now->copy()->endOfMonth()->toDateString(),
            'yearOptions' => range($now->year, $now->year - 4),
            'reportTypes' => $this->reportTypeOptions(),
        ]);
    }

    /**
     * Generate and download a PDF summary report for admin usage.
     */
    public function downloadSummary(Request $request): Response
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
            'type' => ['nullable', 'in:' . implode(',', array_keys($this->reportTypeOptions()))],
        ]);

        $generatedAt = now();
        $defaultStart = $generatedAt->copy()->startOfMonth();
        $defaultEnd = $generatedAt->copy()->endOfMonth();

        $reportStart = $request->filled('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : $defaultStart->copy();

        if (!$request->filled('start_date') && $request->filled('end_date')) {
            $reportStart = Carbon::parse($request->input('end_date'))->copy()->startOfDay();
        }

        $reportEnd = $request->filled('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : ($request->filled('start_date')
                ? Carbon::parse($request->input('start_date'))->endOfDay()
                : $defaultEnd->copy());

        if ($reportEnd->lessThan($reportStart)) {
            [$reportStart, $reportEnd] = [$reportEnd->copy(), $reportStart->copy()];
        }

        $reportYear = isset($validated['year']) ? (int) $validated['year'] : $reportStart->copy()->year;
        $reportType = $validated['type'] ?? 'summary';
        $reportTypeLabel = $this->reportTypeOptions()[$reportType] ?? $this->reportTypeOptions()['summary'];

        $sectionVisibility = [
            'users' => in_array($reportType, ['summary', 'users']),
            'products' => in_array($reportType, ['summary', 'products']),
            'testimonials' => in_array($reportType, ['summary', 'testimonials']),
            'contact' => in_array($reportType, ['summary', 'contact']),
        ];

        $userStats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'members' => User::where('role', 'user')->count(),
            'new_this_month' => User::whereBetween('created_at', [$reportStart, $reportEnd])->count(),
        ];

        $productStats = [
            'total' => StrawberryProduct::count(),
            'active' => StrawberryProduct::where('status', 'active')->count(),
            'inactive' => StrawberryProduct::where('status', 'inactive')->count(),
            'out_of_stock' => StrawberryProduct::where('status', 'out_of_stock')->count(),
            'organic' => StrawberryProduct::where('is_organic', true)->count(),
            'total_stock' => StrawberryProduct::sum('stock_quantity'),
        ];

        $recentUsers = User::latest()->take(10)->get(['name', 'email', 'role', 'created_at']);
        $productSnapshot = StrawberryProduct::orderBy('created_at', 'desc')->take(15)->get(['name', 'category', 'price', 'stock_quantity', 'status', 'origin']);

        $testimonialsStats = [
            'total' => Testimonial::count(),
            'approved' => Testimonial::where('is_approved', true)->count(),
            'pending' => Testimonial::where('is_approved', false)->count(),
        ];

        $activeContact = ContactInfo::where('is_active', true)->first();

        $months = collect(range(1, 12))->map(fn ($month) => Carbon::create($reportYear, $month, 1));
        $userTrend = $months->map(fn ($date) => [
            'label' => $date->translatedFormat('M Y'),
            'count' => User::whereBetween('created_at', [
                $date->copy()->startOfMonth(),
                $date->copy()->endOfMonth(),
            ])->count(),
        ]);

        $testimonialRatings = Testimonial::select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('total', 'rating')
            ->toArray();

        $ratingLabelsArray = [];
        $ratingDataArray = [];
        foreach (range(1, 5) as $rating) {
            $ratingLabelsArray[] = $rating . ' ⭐';
            $ratingDataArray[] = (int) ($testimonialRatings[$rating] ?? 0);
        }
        $ratingMax = max($ratingDataArray) ?: 1;

        $testimonialTrendRaw = $months->map(fn ($date) => [
            'label' => $date->translatedFormat('M Y'),
            'count' => Testimonial::whereBetween('created_at', [
                $date->copy()->startOfMonth(),
                $date->copy()->endOfMonth(),
            ])->count(),
        ]);

        $testimonialTrend = $testimonialTrendRaw;

        $userTrendCounts = $userTrend->pluck('count')->map(fn ($value) => (int) $value)->values()->all();
        $userAxisMax = max($userTrendCounts) ?: 0;

        // Calculate new status: Tersedia (active) and Tidak Tersedia (inactive + out_of_stock)
        $tersediaCount = (int) ($productStats['active'] ?? 0);
        $tidakTersediaCount = (int) (($productStats['inactive'] ?? 0) + ($productStats['out_of_stock'] ?? 0));

        // Generate charts (will return base64, DomPDF should handle it)
        $productStatusChart = $this->generateChartImage([
            'type' => 'doughnut',
            'data' => [
                'labels' => ['Tersedia', 'Tidak Tersedia'],
                'datasets' => [[
                    'data' => [$tersediaCount, $tidakTersediaCount],
                    'backgroundColor' => ['#22c55e', '#6b7280'],
                ]],
            ],
            'options' => [
                'plugins' => ['legend' => ['position' => 'bottom']],
            ],
        ]);

        $ratingChart = $this->generateChartImage([
            'type' => 'bar',
            'data' => [
                'labels' => $ratingLabelsArray,
                'datasets' => [[
                    'label' => 'Jumlah Testimoni',
                    'data' => $ratingDataArray,
                    'backgroundColor' => '#f97316',
                ]],
            ],
            'options' => [
                'plugins' => ['legend' => ['display' => false]],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'stepSize' => 1,
                        ],
                    ],
                ],
            ],
        ]);

        $userTrendChart = $this->generateChartImage([
            'type' => 'line',
            'data' => [
                'labels' => $userTrend->pluck('label')->values()->all(),
                'datasets' => [[
                    'label' => 'Registrasi User',
                    'data' => $userTrendCounts,
                    'borderColor' => '#dc2626',
                    'backgroundColor' => 'rgba(220,38,38,0.15)',
                    'borderWidth' => 3,
                    'fill' => true,
                ]],
            ],
            'options' => [
                'plugins' => ['legend' => ['display' => false]],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'stepSize' => 1,
                        ],
                    ],
                    'x' => [
                        'ticks' => [
                            'maxRotation' => 0,
                            'autoSkip' => true,
                        ],
                    ],
                ],
            ],
        ]);

        $testimonialTrendCounts = $testimonialTrend->pluck('count')->map(fn ($value) => (int) $value)->values()->all();
        $testimonialAxisMax = max($testimonialTrendCounts) ?: 0;

        $testimonialTrendChart = $this->generateChartImage([
            'type' => 'bar',
            'data' => [
                'labels' => $testimonialTrend->pluck('label')->values()->all(),
                'datasets' => [[
                    'label' => 'Testimoni Masuk',
                    'data' => $testimonialTrendCounts,
                    'backgroundColor' => '#10b981',
                ]],
            ],
            'options' => [
                'plugins' => ['legend' => ['display' => false]],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'stepSize' => 1,
                        ],
                    ],
                ],
            ],
        ]);

        // Check if GD extension is available for image processing
        if (!extension_loaded('gd')) {
            // If GD is not available, set charts to null
            $userTrendChart = null;
            $testimonialTrendChart = null;
            $productStatusChart = null;
            $ratingChart = null;
        }

        $pdf = Pdf::setOption([
            'isRemoteEnabled' => false, // Disable remote to avoid GD requirement
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => false,
        ])->loadView('admin.reports.summary', [
            'generatedAt' => $generatedAt,
            'reportStart' => $reportStart,
            'reportEnd' => $reportEnd,
            'userStats' => $userStats,
            'productStats' => $productStats,
            'recentUsers' => $recentUsers,
            'productSnapshot' => $productSnapshot,
            'testimonialsStats' => $testimonialsStats,
            'activeContact' => $activeContact,
            'reportYear' => $reportYear,
            'reportType' => $reportType,
            'reportTypeLabel' => $reportTypeLabel,
            'sectionVisibility' => $sectionVisibility,
            'userTrend' => $userTrend,
            'testimonialTrend' => $testimonialTrend,
            'userTrendChart' => $userTrendChart,
            'testimonialTrendChart' => $testimonialTrendChart,
            'productStatusChart' => $productStatusChart,
            'ratingChart' => $ratingChart,
            'ratingLabels' => $ratingLabelsArray,
            'ratingData' => $ratingDataArray,
        ])->setPaper('a4', 'portrait');

        $fileName = 'laporan-ovaltin-' . $generatedAt->timestamp . '-' . uniqid() . '.pdf';

        return $pdf->stream($fileName);
    }

    protected function reportTypeOptions(): array
    {
        return [
            'summary' => 'Ringkasan Lengkap',
            'users' => 'Fokus Pengguna',
            'products' => 'Fokus Produk',
            'testimonials' => 'Fokus Testimoni',
            'contact' => 'Kontak Perusahaan',
        ];
    }

    protected function generateChartImage(array $config): ?string
    {
        try {
            // Download image dari quickchart.io
            $response = Http::timeout(10)->get('https://quickchart.io/chart', [
                'width' => 700,
                'height' => 300,
                'format' => 'png',
                'c' => json_encode($config),
            ]);

            if ($response->successful()) {
                // Simpan ke storage public directory
                $storagePath = storage_path('app/public/charts');
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }
                
                $fileName = 'chart_' . uniqid() . '_' . time() . '.png';
                $filePath = $storagePath . '/' . $fileName;
                
                file_put_contents($filePath, $response->body());
                
                // Return absolute file path untuk DomPDF
                return $filePath;
            }
        } catch (\Exception $e) {
            \Log::error('Chart generation failed: ' . $e->getMessage());
        }

        return null;
    }
}

