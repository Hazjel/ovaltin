@extends('layouts.app')

@section('title', 'Panel Laporan Admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Panel Laporan Admin</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Sesuaikan periode dan jenis laporan sebelum mengunduh PDF.
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <form action="{{ route('admin.reports.summary') }}" method="GET" target="_blank" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ old('start_date', request('start_date', $defaultStart)) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500">Tanggal awal periode laporan.</p>
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ old('end_date', request('end_date', $defaultEnd)) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                    >
                    <p class="mt-1 text-xs text-gray-500">Opsional, kosongkan jika sama dengan tanggal mulai.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Tahun Tren</label>
                    <select
                        id="year"
                        name="year"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                    >
                        @foreach($yearOptions as $year)
                            <option value="{{ $year }}" {{ (string) $year === request('year', (string) now()->year) ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Menentukan tahun untuk grafik tren pengguna & testimoni.</p>
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Laporan</label>
                    <select
                        id="type"
                        name="type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                    >
                        @foreach($reportTypes as $key => $label)
                            <option value="{{ $key }}" {{ request('type', 'summary') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Pilih ringkasan penuh atau fokus pada data tertentu.</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                <div class="text-sm text-gray-500">
                    PDF akan dibuka pada tab baru. Pastikan pop-up diizinkan oleh browser Anda.
                </div>
                <div class="flex space-x-3">
                    <button type="reset" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Reset
                    </button>
                    <button type="submit" class="inline-flex items-center px-5 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Unduh Laporan PDF
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900">Jenis Laporan</h3>
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach($reportTypes as $key => $label)
                <div class="border border-gray-100 rounded-lg p-4">
                    <p class="text-sm font-medium text-gray-900">{{ $label }}</p>
                    <p class="mt-1 text-xs text-gray-500">
                        @switch($key)
                            @case('summary')
                                Menampilkan seluruh bagian laporan (pengguna, produk, testimoni, dan kontak).
                                @break
                            @case('users')
                                Fokus pada metrik, tren, dan daftar pengguna terbaru.
                                @break
                            @case('products')
                                Hanya memuat statistik stok serta cuplikan produk terbaru.
                                @break
                            @case('testimonials')
                                Menyoroti performa testimoni termasuk distribusi rating dan tren bulanan.
                                @break
                            @case('contact')
                                Menghasilkan dokumen dengan informasi kontak utama perusahaan.
                                @break
                            @default
                                Pilihan kustom.
                        @endswitch
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
