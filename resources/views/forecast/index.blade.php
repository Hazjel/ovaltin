@extends('layouts.app')

@section('title', 'Forecast Penjualan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Forecast Penjualan
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Prediksi penjualan produk menggunakan regresi linear
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
            <a href="{{ route('sales-data.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Kembali ke Data Penjualan
            </a>
            <!-- Days Selector -->
            <form action="{{ route('forecast.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="hidden" name="model_type" value="linear">
                <label for="forecast_days" class="text-sm text-gray-700">Hari Forecast:</label>
                <select id="forecast_days" name="forecast_days" onchange="this.form.submit()" 
                        class="border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="7" {{ $forecastDays == 7 ? 'selected' : '' }}>7 Hari</option>
                    <option value="14" {{ $forecastDays == 14 ? 'selected' : '' }}>14 Hari</option>
                    <option value="30" {{ $forecastDays == 30 ? 'selected' : '' }}>30 Hari</option>
                    <option value="60" {{ $forecastDays == 60 ? 'selected' : '' }}>60 Hari</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    @if(!empty($summary))
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5">
        @foreach($summary as $product => $stats)
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($product, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">{{ ucfirst($product) }}</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ number_format($stats['avg_forecast'], 0) }}</dd>
                            <dd class="text-xs text-gray-500">Rata-rata /hari</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Total {{ $forecastDays }} hari:</span>
                        <span class="font-semibold text-gray-900">{{ number_format($stats['total_forecast'], 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Forecasting Charts -->
    @if(!empty($chartData))
    <div class="grid grid-cols-1 gap-6">
        @foreach($chartData as $product => $data)
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ ucfirst($product) }} - Forecast Penjualan
                        <span class="text-sm font-normal text-gray-500">
                            (Regresi Linear)
                        </span>
                    </h3>
                    <div class="flex items-center space-x-4 text-sm">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                            <span class="text-gray-600">Data Historis</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                            <span class="text-gray-600">Regresi Linear</span>
                        </div>
                    </div>
                </div>
                
                <!-- Metrics -->
                <div class="grid grid-cols-3 gap-4 mb-4 p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-xs text-gray-500">R² Score</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($data['metrics']['r2'], 4) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">RMSE</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($data['metrics']['rmse'], 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">MAE</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($data['metrics']['mae'], 2) }}</p>
                    </div>
                </div>
                
                <div class="h-96">
                    <canvas id="chart-{{ $product }}"></canvas>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Forecast Table -->
    @if(!empty($forecastResults))
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tabel Prediksi Penjualan</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            @foreach($products as $product)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucfirst($product) }}</th>
                            @endforeach
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @for($i = 0; $i < $forecastDays; $i++)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if(isset($forecastResults['Agar']) && $forecastResults['Agar']['success'] && isset($forecastResults['Agar']['forecast'][$i]))
                                    {{ \Carbon\Carbon::parse($forecastResults['Agar']['forecast'][$i]['date'])->format('d/m/Y') }}
                                @endif
                            </td>
                            @php
                                $rowTotal = 0;
                            @endphp
                            @foreach($products as $product)
                                @if(isset($forecastResults[$product]) && $forecastResults[$product]['success'] && isset($forecastResults[$product]['forecast'][$i]))
                                    @php
                                        $quantity = $forecastResults[$product]['forecast'][$i]['quantity'];
                                        $rowTotal += $quantity;
                                    @endphp
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($quantity, 0) }}
                                    </td>
                                @else
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                @endif
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ number_format($rowTotal, 0) }}
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(!empty($chartData))
    @foreach($chartData as $product => $data)
    const ctx{{ str_replace(' ', '', ucfirst($product)) }} = document.getElementById('chart-{{ $product }}');
    const chart{{ str_replace(' ', '', ucfirst($product)) }} = new Chart(ctx{{ str_replace(' ', '', ucfirst($product)) }}, {
        type: 'line',
        data: {
            labels: [
                ...@json($data['historical']['labels']),
                ...@json($data['forecast']['labels'])
            ],
            datasets: [
                {
                    label: 'Data Historis',
                    data: [
                        ...@json($data['historical']['actual']),
                        ...Array(@json(count($data['forecast']['labels']))).fill(null)
                    ],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    tension: 0.4,
                },
                {
                    label: 'Regresi Linear',
                    data: [
                        ...@json($data['historical']['predicted']),
                        @if(isset($data['linear_regression_extended']))
                        ...@json($data['linear_regression_extended'])
                        @else
                        ...@json($data['forecast']['values'])
                        @endif
                    ],
                    borderColor: '#10b981',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointRadius: 0,
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += Math.round(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Tanggal'
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45,
                        callback: function(value, index) {
                            const label = this.getLabelForValue(value);
                            if (label && label.includes('/')) {
                                return label;
                            }
                            if (label && label.includes('-')) {
                                const parts = label.split('-');
                                if (parts.length === 3) {
                                    return parts[2] + '/' + parts[1] + '/' + parts[0];
                                }
                            }
                            return label;
                        }
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Jumlah Penjualan'
                    },
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false,
            }
        }
    });
    @endforeach
    @endif
</script>
@endsection

