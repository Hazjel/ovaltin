<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesData;
use App\Models\StrawberryProduct;
use App\Services\ForecastService;

class ForecastController extends Controller
{
    public function index(Request $request)
    {
        $forecastDays = $request->get('forecast_days', 30);
        $selectedProduct = $request->get('product', 'Agar');
        $modelType = 'linear';

        $products = StrawberryProduct::orderBy('name')->get();
        $summary = [];
        $chartData = [];
        $forecastResults = [];
        $forecastService = app(ForecastService::class);

        foreach ($products as $product) {
            $productSales = SalesData::where('strawberry_product_id', $product->id)
                ->orderBy('tanggal_penjualan', 'asc')
                ->get();

            if ($productSales->count() < 3) {
                $forecastResults[$product->name] = ['success' => false];
                continue;
            }

            $forecastResult = $forecastService->forecast($product->name, $productSales, $forecastDays, $modelType);

            if (!$forecastResult) {
                $forecastResults[$product->name] = ['success' => false];
                continue;
            }

            $totalForecast = array_sum($forecastResult['forecast']['values']);
            $avgForecast = $totalForecast / $forecastDays;

            $summary[$product->name] = [
                'avg_forecast' => $avgForecast,
                'total_forecast' => $totalForecast,
            ];

            $predictedValues = $forecastResult['linear_regression']['values'] ?? $forecastResult['historical']['values'];
            $linearRegressionExtended = $forecastResult['forecast']['values'] ?? [];

            $chartData[$product->name] = [
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

            $forecastResults[$product->name] = [
                'success' => true,
                'forecast' => array_map(function ($date, $value) {
                    return [
                        'date' => $date,
                        'quantity' => $value,
                    ];
                }, $forecastResult['forecast']['dates'], $forecastResult['forecast']['values']),
            ];
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
        $productParam = $request->get('product', 'Agar');
        $forecastDays = $request->get('forecast_days', 30);
        $modelType = 'linear';

        // Accept product id or name for backward-compat
        $product = is_numeric($productParam)
            ? StrawberryProduct::find($productParam)
            : StrawberryProduct::where('name', $productParam)->first();

        if (!$product) {
            return response()->json([
                'error' => 'Produk tidak ditemukan.',
            ], 404);
        }

        $salesData = SalesData::where('strawberry_product_id', $product->id)
            ->orderBy('tanggal_penjualan', 'asc')
            ->get();

        if ($salesData->count() < 3) {
            return response()->json([
                'error' => 'Data historis terlalu sedikit untuk melakukan prediksi (minimal 3 data)',
            ], 400);
        }

        try {
            $forecastService = app(ForecastService::class);
            $result = $forecastService->forecast($product->name, $salesData, $forecastDays, $modelType);

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

