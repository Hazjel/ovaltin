@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Data Penjualan
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola data penjualan, visualisasi, dan laporan performa
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
            <a href="{{ route('forecast.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Lihat Forecast
            </a>
            <button onclick="document.getElementById('excel-upload').click()" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Upload Excel
            </button>
            <form id="upload-form" action="{{ route('sales-data.upload-excel') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file" id="excel-upload" name="excel_file" accept=".xlsx,.xls" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Penjualan</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ number_format($summary['total_sales']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Transaksi</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ number_format($summary['total_transactions']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rata-rata/Transaksi</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ number_format($summary['avg_per_transaction'], 0) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Jumlah Produk</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ count($products) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Input Data Penjualan -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Input Data Penjualan</h3>
            <form action="{{ route('sales-data.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <div>
                        <label for="tanggal_penjualan" class="block text-sm font-medium text-gray-700">Tanggal Penjualan</label>
                        <input type="date" name="tanggal_penjualan" id="tanggal_penjualan" value="{{ date('Y-m-d') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <select name="nama_produk" id="nama_produk" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product }}">{{ $product }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="jumlah_terjual" class="block text-sm font-medium text-gray-700">Jumlah Terjual</label>
                        <input type="number" name="jumlah_terjual" id="jumlah_terjual" min="0" step="1" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="0">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Visualisasi Data Per Bulan -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    @if($monthlyData['type'] == 'daily')
                        Visualisasi Data Harian - {{ $monthlyData['month_name'] }}
                    @else
                        Visualisasi Data Per Bulan
                    @endif
                </h3>
                <form action="{{ route('sales-data.index') }}" method="GET" class="flex items-center space-x-2" id="filter-form">
                    <label for="year" class="text-sm text-gray-700">Tahun:</label>
                    <select id="year" name="year" 
                            class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @for($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <label for="month" class="text-sm text-gray-700 ml-2">Bulan:</label>
                    <select id="month" name="month" 
                            class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Bulan</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == $selectedMonth ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create($selectedYear, $m, 1)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                    <script>
                        document.getElementById('year').addEventListener('change', function() {
                            document.getElementById('filter-form').submit();
                        });
                        document.getElementById('month').addEventListener('change', function() {
                            document.getElementById('filter-form').submit();
                        });
                    </script>
                </form>
                        </div>
            <div class="mt-6 h-80">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Ranking Produk Paling Laku -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ranking Produk Paling Laku</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ranking</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Terjual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $totalAll = $topProducts->sum('total_terjual');
                        @endphp
                        @foreach($topProducts as $product)
                            @php
                                $percentage = $totalAll > 0 ? ($product['total_terjual'] / $totalAll) * 100 : 0;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                                        @if($product['rank'] == 1)
                                            <span class="text-2xl">🥇</span>
                                        @elseif($product['rank'] == 2)
                                            <span class="text-2xl">🥈</span>
                                        @elseif($product['rank'] == 3)
                                            <span class="text-2xl">🥉</span>
                                        @else
                                            <span class="text-lg font-semibold text-gray-600">#{{ $product['rank'] }}</span>
                                        @endif
                        </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $product['nama_produk'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($product['total_terjual']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600">{{ number_format($percentage, 1) }}%</span>
                        </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                        </div>
                    </div>
                </div>
                
    <!-- Generate Laporan Performa Penjualan -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Generate Laporan Performa Penjualan</h3>
            <form id="report-form" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" 
                               value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input type="date" id="end_date" name="end_date" 
                               value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="generateReport()" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Generate Laporan
                        </button>
                    </div>
                </div>
            </form>
            <div id="report-result" class="mt-6 hidden">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-md font-semibold text-gray-900">Hasil Laporan</h4>
                        <button type="button" onclick="downloadReport()" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download Excel
                        </button>
                    </div>
                    <div id="report-content"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Penjualan -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Penjualan</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Terjual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($salesHistory as $sale)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($sale->tanggal_penjualan)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ ucfirst($sale->nama_produk) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($sale->jumlah_terjual, 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button onclick="editSalesData({{ $sale->id }})" 
                                            class="text-blue-600 hover:text-blue-900" 
                                            title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('sales-data.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada data penjualan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $salesHistory->links() }}
            </div>
        </div>
        </div>
    </div>

<!-- Modal Edit Data Penjualan -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Edit Data Penjualan</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_tanggal_penjualan" class="block text-sm font-medium text-gray-700">Tanggal Penjualan</label>
                    <input type="date" name="tanggal_penjualan" id="edit_tanggal_penjualan" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="edit_nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <select name="nama_produk" id="edit_nama_produk" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product }}">{{ $product }}</option>
                        @endforeach
                    </select>
        </div>
                <div>
                    <label for="edit_jumlah_terjual" class="block text-sm font-medium text-gray-700">Jumlah Terjual</label>
                    <input type="number" name="jumlah_terjual" id="edit_jumlah_terjual" min="0" step="1" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="0">
    </div>
                <div class="flex items-center justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Simpan Perubahan
            </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Edit Sales Data Function
    function editSalesData(id) {
        fetch('{{ url("sales-data") }}/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = '{{ url("sales-data") }}/' + id;
                document.getElementById('edit_tanggal_penjualan').value = data.tanggal_penjualan;
                document.getElementById('edit_nama_produk').value = data.nama_produk;
                document.getElementById('edit_jumlah_terjual').value = data.jumlah_terjual;
                document.getElementById('editModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data');
            });
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editForm').reset();
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            closeEditModal();
        }
    }
</script>
<script>
    // Monthly/Daily Chart
    const monthlyCtx = document.getElementById('monthlyChart');
    
    @if($monthlyData['type'] == 'daily')
        // Daily chart (per hari dalam bulan)
        const chartData = {
            labels: @json($monthlyData['data']->pluck('date')),
            datasets: [
                @foreach($products as $index => $product)
                {
                    label: '{{ $product }}',
                    data: @json($monthlyData['data']->map(function($day) use ($product) {
                        return isset($day['data'][$product]) ? $day['data'][$product] : 0;
                    })->values()),
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                    ][{{ $index }}],
                    borderColor: [
                        'rgb(239, 68, 68)',
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)',
                        'rgb(251, 146, 60)',
                    ][{{ $index }}],
                    borderWidth: 1
                },
                @endforeach
            ]
        };
    @else
        // Monthly chart (per bulan dalam tahun)
        const chartData = {
            labels: @json($monthlyData['data']->pluck('month')),
            datasets: [
                @foreach($products as $index => $product)
                {
                    label: '{{ $product }}',
                    data: @json($monthlyData['data']->map(function($month) use ($product) {
                        return isset($month['data'][$product]) ? $month['data'][$product] : 0;
                    })->values()),
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                    ][{{ $index }}],
                    borderColor: [
                        'rgb(239, 68, 68)',
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)',
                        'rgb(251, 146, 60)',
                    ][{{ $index }}],
                    borderWidth: 1
                },
                @endforeach
            ]
        };
    @endif
    
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    ticks: {
                        @if($monthlyData['type'] == 'daily')
                        maxRotation: 45,
                        minRotation: 45,
                        @endif
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Store report dates for download
    let reportStartDate = '';
    let reportEndDate = '';

    // Generate Report
    function generateReport() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        if (!startDate || !endDate) {
            alert('Mohon pilih tanggal mulai dan tanggal akhir');
            return;
        }
        
        // Store dates for download
        reportStartDate = startDate;
        reportEndDate = endDate;
        
        fetch('{{ route("sales-data.generate-report") }}?start_date=' + startDate + '&end_date=' + endDate)
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('report-result');
                const contentDiv = document.getElementById('report-content');
                
                let html = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Penjualan</p>
                            <p class="text-2xl font-bold text-gray-900">${data.summary.total_sales.toLocaleString()}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Transaksi</p>
                            <p class="text-2xl font-bold text-gray-900">${data.summary.total_transactions.toLocaleString()}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Rata-rata/Transaksi</p>
                            <p class="text-2xl font-bold text-gray-900">${data.summary.avg_per_transaction.toLocaleString()}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5 class="font-semibold mb-2">Per Produk:</h5>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Produk</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Total</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Transaksi</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Rata-rata</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Min</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Max</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                `;
                
                for (const [product, stats] of Object.entries(data.products)) {
                    html += `
                        <tr>
                            <td class="px-4 py-2 text-sm">${product}</td>
                            <td class="px-4 py-2 text-sm">${stats.total.toLocaleString()}</td>
                            <td class="px-4 py-2 text-sm">${stats.count}</td>
                            <td class="px-4 py-2 text-sm">${stats.avg.toFixed(2)}</td>
                            <td class="px-4 py-2 text-sm">${stats.min}</td>
                            <td class="px-4 py-2 text-sm">${stats.max}</td>
                        </tr>
                    `;
                }
                
                html += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
                
                contentDiv.innerHTML = html;
                resultDiv.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat generate laporan');
            });
    }

    // Download Report as Excel
    function downloadReport() {
        const startDate = reportStartDate || document.getElementById('start_date').value;
        const endDate = reportEndDate || document.getElementById('end_date').value;
        
        if (!startDate || !endDate) {
            alert('Mohon generate laporan terlebih dahulu atau pilih tanggal mulai dan tanggal akhir');
            return;
        }
        
        // Create download URL
        const downloadUrl = '{{ route("sales-data.download-report") }}?start_date=' + startDate + '&end_date=' + endDate;
        
        // Create temporary link and trigger download
        const link = document.createElement('a');
        link.href = downloadUrl;
        link.download = 'Laporan_Performa_Penjualan_' + startDate + '_' + endDate + '.xlsx';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
