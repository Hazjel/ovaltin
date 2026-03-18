@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Admin Dashboard
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola sistem dan pengguna dashboard stroberi
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3 items-center">
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-pink-600 bg-white hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m0 0H8m4 0h4M4 6h16M4 10h16"></path>
                </svg>
                Panel Laporan
            </a>
            <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                Kelola User
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Users -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalUsers }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Admins</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalAdmins }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Produk</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalProducts }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Stock -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Stok</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($totalStock) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Visualization -->
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-4">
        <div class="bg-white shadow rounded-lg xl:col-span-2">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Pertumbuhan User 12 Bulan Terakhir</h3>
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center space-x-2">
                        <label for="year-users" class="text-xs text-gray-500">Tahun</label>
                        <select id="year-users" name="year" class="text-xs border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500" onchange="this.form.submit()">
                            @foreach($yearOptions as $year)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="mt-6 h-64">
                    <canvas id="userTrendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg xl:col-span-2">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Distribusi Status Produk</h3>
                </div>
                <div class="mt-6 h-64">
                    <canvas id="productStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg xl:col-span-2">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Pertumbuhan Testimoni 12 Bulan Terakhir</h3>
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center space-x-2">
                        <label for="year-testimonials" class="text-xs text-gray-500">Tahun</label>
                        <select id="year-testimonials" name="year" class="text-xs border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500" onchange="this.form.submit()">
                            @foreach($yearOptions as $year)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="mt-6 h-64">
                    <canvas id="testimonialTrendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg xl:col-span-2">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Testimoni per Rating</h3>
                </div>
                <div class="mt-6 h-64">
                    <canvas id="testimonialChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">User Terbaru</h3>
                <a href="{{ route('admin.users') }}" class="text-sm text-pink-600 hover:text-red-500">Lihat semua</a>
            </div>
            <div class="space-y-3">
                @forelse($recentUsers as $user)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8">
                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $user->role }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada user terdaftar.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- User Guide WhatsApp PDF -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">User Guide WhatsApp</h3>
                    <p class="mt-1 text-sm text-gray-500">Panduan penggunaan WhatsApp Business untuk pengguna</p>
                </div>
                <a href="{{ asset('documents/User-Guide-WhatsApp.pdf') }}" target="_blank" download class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
            </div>
            <div class="mt-4 border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                <div class="bg-white p-2 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">User-Guide-WhatsApp.pdf</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ asset('documents/User-Guide-WhatsApp.pdf') }}" target="_blank" class="text-sm text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            <span>Buka di tab baru</span>
                        </a>
                    </div>
                </div>
                <div class="relative" style="height: 700px;">
                    <iframe 
                        src="{{ asset('documents/User-Guide-WhatsApp.pdf') }}#toolbar=1&navpanes=1&scrollbar=1&zoom=page-width" 
                        class="w-full h-full" 
                        style="min-height: 700px;"
                        frameborder="0"
                        id="pdf-viewer">
                    </iframe>
                    <div id="pdf-fallback" class="hidden absolute inset-0 flex items-center justify-center bg-gray-100">
                        <div class="text-center p-6 bg-white rounded-lg shadow-lg max-w-md">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-600 mb-4">Browser Anda tidak mendukung preview PDF langsung.</p>
                            <a href="{{ asset('documents/User-Guide-WhatsApp.pdf') }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Buka PDF di Tab Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('strawberry-products.create') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-pink-50 text-pink-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Tambah Produk
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Tambahkan produk stroberi baru ke dalam sistem.
                        </p>
                    </div>
                </a>

                <a href="{{ route('admin.users') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-pink-50 text-pink-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Kelola User
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Kelola pengguna dan peran akses sistem.
                        </p>
                    </div>
                </a>

                <a href="{{ route('strawberry-products.index') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-green-50 text-green-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Lihat Produk
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Lihat dan kelola semua produk stroberi.
                        </p>
                    </div>
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-pink-50 text-pink-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Kelola Testimoni
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Kelola dan moderasi testimoni pelanggan.
                        </p>
                    </div>
                </a>

                <a href="{{ route('admin.faqs.index') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-pink-50 text-pink-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Kelola FAQ
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Kelola pertanyaan yang sering diajukan (FAQ)
                        </p>
                    </div>
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12l1.414 1.414A1 1 0 0021 16h-1zm-2-2l1.414 1.414A1 1 0 0018 13h-1zm-2-2l1.414 1.414A1 1 0 0015 10h-1zm-2-2l1.414 1.414A1 1 0 0012 7h-1zm-2-2l1.414 1.414A1 1 0 009 4H8zm-2-2l1.414 1.414A1 1 0 006 1H5zM3 3v18h18V3H3zm16 16H5V5h14v14z"/>
                        </svg>
                    </span>
                </a>
                
                <a href="{{ route('admin.contact.index') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-pink-50 text-pink-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Kelola Kontak
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Kelola informasi kontak perusahaan.
                        </p>
                    </div>
                </a>

                <a href="{{ route('admin.product-introduction.index') }}" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-pink-500 rounded-lg border border-gray-200 hover:border-gray-300">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Edit Dashboard
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Edit informasi yang ditampilkan di dashboard.
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const userTrendCtx = document.getElementById('userTrendChart');
    const productStatusCtx = document.getElementById('productStatusChart');
    const testimonialCtx = document.getElementById('testimonialChart');
    const testimonialTrendCtx = document.getElementById('testimonialTrendChart');

    const userTrendChart = new Chart(userTrendCtx, {
        type: 'line',
        data: {
            labels: @json($userTrendLabels),
            datasets: [{
                label: 'Registrasi User',
                data: @json($userTrendData),
                borderColor: '#dc2626',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: '#ef4444',
                pointBorderColor: '#fff',
                pointRadius: 5,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: Math.max((@json($userTrendMax)) + 1, 3),
                    grace: '10%',
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    const productStatusChart = new Chart(productStatusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($productStatusLabels),
            datasets: [{
                data: @json($productStatusData),
                backgroundColor: ['#22c55e', '#6b7280'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    const testimonialChart = new Chart(testimonialCtx, {
        type: 'bar',
        data: {
            labels: @json($ratingLabels),
            datasets: [{
                label: 'Jumlah Testimoni',
                data: @json($ratingData),
                backgroundColor: '#f97316',
                borderColor: '#ea580c',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: Math.max((@json($ratingMax)) + 1, 3),
                    grace: '15%',
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    const testimonialTrendChart = new Chart(testimonialTrendCtx, {
        type: 'bar',
        data: {
            labels: @json($testimonialTrendLabels),
            datasets: [{
                label: 'Testimoni Masuk',
                data: @json($testimonialTrendData),
                backgroundColor: '#10b981',
                borderColor: '#0f766e',
                borderWidth: 2,
                borderRadius: 6,
                barPercentage: 0.6,
                categoryPercentage: 0.7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: Math.max((@json($testimonialTrendMax)) + 1, 3),
                    grace: '10%',
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        autoSkip: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Handle PDF viewer fallback
    const pdfViewer = document.getElementById('pdf-viewer');
    const pdfFallback = document.getElementById('pdf-fallback');
    
    if (pdfViewer) {
        pdfViewer.onload = function() {
            // PDF loaded successfully
            pdfFallback.classList.add('hidden');
        };
        
        pdfViewer.onerror = function() {
            // PDF failed to load, show fallback
            pdfFallback.classList.remove('hidden');
        };
        
        // Check if iframe loaded after 3 seconds
        setTimeout(function() {
            try {
                const iframeDoc = pdfViewer.contentDocument || pdfViewer.contentWindow.document;
                if (!iframeDoc || iframeDoc.body.innerHTML.trim() === '') {
                    pdfFallback.classList.remove('hidden');
                }
            } catch (e) {
                // Cross-origin or other error, might still be loading
                // Keep the iframe visible
            }
        }, 3000);
    }
</script>
@endsection
