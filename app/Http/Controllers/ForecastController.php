<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesData;
use App\Services\ForecastService;

class ForecastController extends Controller
{
    public function index(Request $request)
    {
        $forecastDays = $request->get('forecast_days', 30);
        $selectedProduct = $request->get('product', 'Agar');
        $modelType = 'linear'; // Hanya menggunakan regresi linear
        
        // Hitung summary untuk setiap produk
        $products = SalesData::getAvailableProducts();
        $summary = [];
        $chartData = [];
        $forecastResults = [];
        $forecastService = app(ForecastService::class);
        
        foreach ($products as $product) {
            // Ambil data historis
            $productSales = SalesData::where('nama_produk', $product)
                ->orderBy('tanggal_penjualan', 'asc')
                ->get();
            
            if ($productSales->count() >= 3) {
                // Lakukan forecasting dengan regresi linear
                $forecastResult = $forecastService->forecast($product, $productSales, $forecastDays, $modelType);
                
                if ($forecastResult) {
                    // Summary
                    $totalForecast = array_sum($forecastResult['forecast']['values']);
                    $avgForecast = $totalForecast / $forecastDays;
                    
                    $summary[$product] = [
                        'avg_forecast' => $avgForecast,
                        'total_forecast' => $totalForecast,
                    ];
                    
                    // Chart data
                    $predictedValues = $forecastResult['linear_regression']['values'] ?? $forecastResult['historical']['values'];
                    
                    // Hitung regresi linear yang dilanjutkan untuk periode forecast
                    $linearRegressionExtended = [];
                    if (isset($forecastResult['forecast']['values'])) {
                        $linearRegressionExtended = $forecastResult['forecast']['values'];
                    }
                    
                    $chartData[$product] = [
                        'historical' => [
                            'labels' => $forecastResult['historical']['dates'],
                            'actual' => $forecastResult['historical']['values'],
                            'predicted' => $predictedValues,
                        ],
                        'forecast' => [
                            'labels' => $forecastResult['forecast']['dates'],
                            'values' => $forecastResult['forecast']['values'],
                        ],
                        'linear_regression_extended' => $linearRegressionExtended,
                        'metrics' => [
                            'r2' => $forecastResult['metrics']['R2 Score'],
                            'rmse' => $forecastResult['metrics']['RMSE'],
                            'mae' => $forecastResult['metrics']['MAE'],
                        ],
                        'model_type' => 'linear',
                    ];
                    
                    // Forecast results untuk tabel
                    $forecastResults[$product] = [
                        'success' => true,
                        'forecast' => array_map(function($date, $value) {
                            return [
                                'date' => $date,
                                'quantity' => $value,
                            ];
                        }, $forecastResult['forecast']['dates'], $forecastResult['forecast']['values']),
                    ];
                } else {
                    $forecastResults[$product] = ['success' => false];
                }
            } else {
                $forecastResults[$product] = ['success' => false];
            }
        }
        
        return view('forecast.index', compact(
            'summary', 
            'forecastDays', 
            'selectedProduct', 
            'products',
            'chartData',
            'forecastResults',
            'modelType'
        ));
    }

    public function getPrediction(Request $request)
    {
        $product = $request->get('product', 'Agar');
        $forecastDays = $request->get('forecast_days', 30);
        $modelType = 'linear'; // Hanya menggunakan regresi linear

        // Ambil data historis dari database
        $salesData = SalesData::where('nama_produk', $product)
            ->orderBy('tanggal_penjualan', 'asc')
            ->get();

        if ($salesData->count() < 3) {
            return response()->json([
                'error' => 'Data historis terlalu sedikit untuk melakukan prediksi (minimal 3 data)',
            ], 400);
        }

        // Panggil service untuk melakukan forecasting
        try {
            $forecastService = app(ForecastService::class);
            $result = $forecastService->forecast($product, $salesData, $forecastDays, $modelType);

            if (!$result) {
                return response()->json([
                    'error' => 'Gagal melakukan prediksi. Pastikan data historis cukup (minimal 3 data).',
                ], 400);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}

