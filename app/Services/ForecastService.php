<?php

namespace App\Services;

use App\Models\SalesData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

class ForecastService
{
    private $pythonScriptPath;

    public function __construct()
    {
        $this->pythonScriptPath = base_path('laravel/forecast_models.py');
    }

    /**
     * Melakukan forecasting untuk produk tertentu
     *
     * @param string $productName
     * @param \Illuminate\Support\Collection $salesData
     * @param int $forecastDays
     * @param string $modelType 'linear' or 'decision_tree'
     * @return array|null
     */
    public function forecast($productName, $salesData, $forecastDays = 30, $modelType = 'linear')
    {
        try {
            // Siapkan data untuk Python script
            $data = $salesData->map(function ($item) {
                return [
                    'tanggal_penjualan' => $item->tanggal_penjualan->format('Y-m-d'),
                    'nama_produk' => $item->nama_produk,
                    'jumlah_terjual' => $item->jumlah_terjual,
                ];
            })->toArray();

            // Buat file JSON temporary untuk data
            $tempDataFile = storage_path('app/temp_sales_data_' . time() . '.json');
            file_put_contents($tempDataFile, json_encode($data));

            // Jalankan Python script
            $pythonPath = $this->getPythonPath();
            
            // Jika Python tidak ditemukan, gunakan fallback
            if (!$pythonPath) {
                if (file_exists($tempDataFile)) {
                    unlink($tempDataFile);
                }
                return $this->forecastSimple($productName, $salesData, $forecastDays, $modelType);
            }
            
            $scriptPath = base_path('laravel/forecast_models.py');

            $command = sprintf(
                '%s %s --product "%s" --data-file "%s" --forecast-days %d --model-type %s',
                $pythonPath,
                escapeshellarg($scriptPath),
                escapeshellarg($productName),
                escapeshellarg($tempDataFile),
                $forecastDays,
                escapeshellarg($modelType)
            );

            $result = Process::run($command);

            // Hapus file temporary
            if (file_exists($tempDataFile)) {
                unlink($tempDataFile);
            }

            if ($result->failed()) {
                Log::error('Forecast failed', [
                    'error' => $result->errorOutput(),
                    'output' => $result->output(),
                ]);
                // Fallback ke metode sederhana
                return $this->forecastSimple($productName, $salesData, $forecastDays, $modelType);
            }

            $output = json_decode($result->output(), true);

            if (!$output || isset($output['error'])) {
                Log::error('Failed to parse forecast output', [
                    'output' => $result->output(),
                ]);
                // Fallback ke metode sederhana
                return $this->forecastSimple($productName, $salesData, $forecastDays, $modelType);
            }

            return $output;

        } catch (\Exception $e) {
            Log::error('Forecast exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Fallback ke metode sederhana jika Python tidak tersedia
            return $this->forecastSimple($productName, $salesData, $forecastDays);
        }
    }

    /**
     * Get Python executable path
     */
    private function getPythonPath()
    {
        // Coba beberapa kemungkinan path Python
        $possiblePaths = [
            'python3',
            'python',
            'py', // Windows
        ];

        foreach ($possiblePaths as $path) {
            try {
                $result = Process::run("$path --version");
                if ($result->successful()) {
                    return $path;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // Jika Python tidak ditemukan, return null untuk trigger fallback
        return null;
    }

    /**
     * Forecast menggunakan metode sederhana (fallback jika Python tidak tersedia)
     */
    public function forecastSimple($productName, $salesData, $forecastDays = 30, $modelType = 'linear')
    {
        if ($salesData->count() < 3) {
            return null;
        }

        // Historical data
        $historicalDates = $salesData->pluck('tanggal_penjualan')->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->toArray();
        $historicalValues = $salesData->pluck('jumlah_terjual')->toArray();

        // Linear regression calculation
        $linearPredictions = [];
        $slope = 0;
        $intercept = 0;
        $n = count($historicalValues);
        
        if ($n > 1) {
            $sumX = array_sum(range(1, $n));
            $sumY = array_sum($historicalValues);
            $sumXY = 0;
            $sumX2 = 0;
            
            foreach (range(1, $n) as $i) {
                $sumXY += $i * $historicalValues[$i - 1];
                $sumX2 += $i * $i;
            }
            
            $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
            $intercept = ($sumY - $slope * $sumX) / $n;
            
            // Hitung prediksi untuk data historis
            foreach (range(1, $n) as $i) {
                $linearPredictions[] = max(0, round($intercept + $slope * $i, 2));
            }
        } else {
            $linearPredictions = $historicalValues;
            $avgPerDay = $n > 0 ? $historicalValues[0] : 0;
            $slope = 0;
            $intercept = $avgPerDay;
        }

        // Generate forecast dates dan values menggunakan regresi linear yang dilanjutkan
        $lastDate = $salesData->max('tanggal_penjualan');
        $forecastDates = [];
        $forecastValues = [];

        for ($i = 1; $i <= $forecastDays; $i++) {
            $date = Carbon::parse($lastDate)->addDays($i);
            $forecastDates[] = $date->format('Y-m-d');
            // Lanjutkan regresi linear: nilai pada titik n+i
            $forecastValue = $intercept + $slope * ($n + $i);
            $forecastValues[] = max(0, round($forecastValue, 2));
        }

        // Calculate metrics
        $r2 = 0.1; // Placeholder
        $rmse = 0;
        $mae = 0;

        if (count($linearPredictions) > 0 && count($historicalValues) > 0) {
            $squaredErrors = [];
            $absoluteErrors = [];
            
            for ($i = 0; $i < min(count($linearPredictions), count($historicalValues)); $i++) {
                $error = $historicalValues[$i] - $linearPredictions[$i];
                $squaredErrors[] = $error * $error;
                $absoluteErrors[] = abs($error);
            }
            
            $rmse = sqrt(array_sum($squaredErrors) / count($squaredErrors));
            $mae = array_sum($absoluteErrors) / count($absoluteErrors);
            
            // Calculate R² score
            $meanY = array_sum($historicalValues) / count($historicalValues);
            $totalSumSquares = 0;
            foreach ($historicalValues as $value) {
                $totalSumSquares += pow($value - $meanY, 2);
            }
            $residualSumSquares = array_sum($squaredErrors);
            if ($totalSumSquares > 0) {
                $r2 = 1 - ($residualSumSquares / $totalSumSquares);
            }
        }

        return [
            'product' => $productName,
            'metrics' => [
                'R2 Score' => round($r2, 4),
                'RMSE' => round($rmse, 2),
                'MAE' => round($mae, 2),
            ],
            'historical' => [
                'dates' => $historicalDates,
                'values' => $historicalValues,
            ],
            'linear_regression' => [
                'dates' => $historicalDates,
                'values' => $linearPredictions,
            ],
            'forecast' => [
                'dates' => $forecastDates,
                'values' => $forecastValues,
            ],
        ];
    }
}

