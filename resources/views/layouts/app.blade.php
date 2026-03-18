<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Produk Stroberi')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Scripts -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback: Using CDN for Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            pink: {
                                50: '#fdf2f8',
                                100: '#fce7f3',
                                200: '#fbcfe8',
                                300: '#f9a8d4',
                                400: '#f472b6',
                                500: '#ec4899',
                                600: '#db2777',
                                700: '#be185d',
                                800: '#9f1239',
                                900: '#831843',
                            }
                        }
                    }
                }
            }
        </script>
    @endif
    <style>
        /* Ensure navbar is full width - break out of container */
        nav.bg-gradient-to-r {
            margin-left: calc(-50vw + 50%) !important;
            margin-right: calc(-50vw + 50%) !important;
            width: 100vw !important;
            max-width: 100vw !important;
            position: relative;
        }
        /* Remove default margins */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }
        .min-h-screen {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }
        
        /* Adjust logout button position to align with text */
        .logout-button-container form {
            margin-top: 2px;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-pink-50 to-slate-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation - Pink Theme -->
        <nav class="shadow-lg sticky top-0 z-50" style="left: 0; right: 0; width: 100vw; margin-left: calc(-50vw + 50%); margin-right: calc(-50vw + 50%); background: #E91E63;">
            <div class="mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 max-w-full">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center p-1">
                                    <img src="{{ asset('images/foto logo.webp') }}" alt="Ovaltin Logo" class="w-full h-full object-cover rounded-full">
                                </div>
                                <span class="ml-3 text-2xl font-bold text-white">Ovaltin</span>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-6 sm:-my-px sm:ml-8 sm:flex items-center">
                            @auth
                                @if(Auth::user()->isAdmin())
                                    {{-- Edit Dashboard link removed --}}
                                @else
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-2 py-1 text-sm font-medium text-white hover:text-white/90 transition">
                                        Dashboard
                                    </a>
                                    
                                    <!-- Dropdown Produk -->
                                    <div class="relative inline-flex items-center px-1 pt-1" x-data="{ open: false }" @click.away="open = false">
                                        <button @click="open = !open" class="inline-flex items-center px-2 py-1 text-sm font-medium text-white hover:text-white/90 transition">
                                            Produk
                                            <svg class="ml-1 h-4 w-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div x-show="open" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 transform translate-y-2"
                                             x-transition:enter-end="opacity-100 transform translate-y-0"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 transform translate-y-0"
                                             x-transition:leave-end="opacity-0 transform translate-y-2"
                                             class="absolute top-full left-0 mt-3 w-72 rounded-2xl shadow-2xl bg-white border border-gray-100 overflow-hidden z-50"
                                             style="display: none;">
                                            <div class="p-3 space-y-2">
                                                <!-- Daftar Produk Card -->
                                                <a href="{{ route('user.products.index') }}" class="block group">
                                                    <div class="bg-gradient-to-br from-pink-50 via-pink-50 to-pink-50 hover:from-pink-100 hover:via-pink-100 hover:to-pink-100 rounded-xl p-4 transition-all duration-200 border-2 border-transparent hover:border-pink-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-10 h-10 bg-gradient-to-br from-pink-600 to-pink-600 rounded-lg flex items-center justify-center shadow-sm">
                                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h3 class="text-sm font-bold text-gray-900 group-hover:text-pink-700 transition-colors">Daftar Produk</h3>
                                                                <p class="text-xs text-gray-600 mt-0.5">Lihat semua produk kami</p>
                                                            </div>
                                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-700 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </a>

                                                <!-- Pengenalan Produk Card -->
                                                <a href="{{ route('dashboard') }}#tentang-kami" class="block group">
                                                    <div class="bg-gradient-to-br from-pink-50 to-pink-50 hover:from-pink-100 hover:to-pink-100 rounded-xl p-4 transition-all duration-200 border-2 border-transparent hover:border-pink-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-500 rounded-lg flex items-center justify-center shadow-sm">
                                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h3 class="text-sm font-bold text-gray-900 group-hover:text-pink-600 transition-colors">Pengenalan Produk</h3>
                                                                <p class="text-xs text-gray-600 mt-0.5">Tentang produk kami</p>
                                                            </div>
                                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-2 py-1 text-sm font-medium text-white hover:text-white/90 transition">
                                    Dashboard
                                </a>
                                
                                <!-- Dropdown Produk -->
                                <div class="relative inline-flex items-center px-1 pt-1" x-data="{ open: false }" @click.away="open = false">
                                    <button @click="open = !open" class="inline-flex items-center px-2 py-1 text-sm font-medium text-white hover:text-white/90 transition">
                                        Produk
                                        <svg class="ml-1 h-4 w-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform translate-y-2"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 transform translate-y-0"
                                         x-transition:leave-end="opacity-0 transform translate-y-2"
                                         class="absolute top-full left-0 mt-3 w-72 rounded-2xl shadow-2xl bg-white border border-gray-100 overflow-hidden z-50"
                                         style="display: none;">
                                        <div class="p-3 space-y-2">
                                            <!-- Daftar Produk Card -->
                                            <a href="{{ route('user.products.index') }}" class="block group">
                                                <div class="bg-gradient-to-br from-pink-50 via-pink-50 to-pink-50 hover:from-pink-100 hover:via-pink-100 hover:to-pink-100 rounded-xl p-4 transition-all duration-200 border-2 border-transparent hover:border-pink-200">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-10 h-10 bg-gradient-to-br from-pink-600 to-pink-600 rounded-lg flex items-center justify-center shadow-sm">
                                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-1">
                                                            <h3 class="text-sm font-bold text-gray-900 group-hover:text-pink-700 transition-colors">Daftar Produk</h3>
                                                            <p class="text-xs text-gray-600 mt-0.5">Lihat semua produk kami</p>
                                                        </div>
                                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-700 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- Pengenalan Produk Card -->
                                            <a href="{{ route('dashboard') }}#tentang-kami" class="block group">
                                                <div class="bg-gradient-to-br from-pink-50 to-pink-50 hover:from-pink-100 hover:to-pink-100 rounded-xl p-4 transition-all duration-200 border-2 border-transparent hover:border-pink-200">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-500 rounded-lg flex items-center justify-center shadow-sm">
                                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-1">
                                                            <h3 class="text-sm font-bold text-gray-900 group-hover:text-pink-600 transition-colors">Pengenalan Produk</h3>
                                                            <p class="text-xs text-gray-600 mt-0.5">Tentang produk kami</p>
                                                        </div>
                                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                            
                            <a href="{{ route('testimonials.index') }}" class="inline-flex items-center px-2 py-1 text-sm font-medium text-white hover:text-white/90 transition">
                                Testimoni
                            </a>
                            <a href="{{ route('contact.index') }}" class="inline-flex items-center px-2 py-1 text-sm font-medium text-white hover:text-white/90 transition">
                                Kontak Kami
                            </a>
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('sales-data.index') }}" class="inline-flex items-center px-2 py-1 text-sm font-medium text-white hover:text-white/90 transition {{ request()->routeIs('sales-data.*') ? 'border-b-2 border-white' : '' }}">
                                        Data Penjualan
                                    </a>
                                @endif
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('strawberry-products.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('strawberry-products.*') ? 'border-white text-white' : 'border-transparent text-white/90 hover:text-white hover:border-white' }}">
                                        Produk Stroberi
                                    </a>
                                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'border-white text-white' : 'border-transparent text-white/90 hover:text-white hover:border-white' }}">
                                        Admin Panel
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center">
                        @auth
                            <div class="flex items-center space-x-3">
                                <span class="text-sm text-white flex items-center">
                                    Selamat datang, <span class="font-medium ml-1">{{ Auth::user()->name }}</span>
                                    @if(Auth::user()->isAdmin())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-white text-pink-400 ml-1 shadow-sm">
                                            Admin
                                        </span>
                                    @endif
                                </span>
                                <form action="{{ route('logout') }}" method="POST" class="inline flex items-center logout-button-container">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-pink-200 text-sm font-medium rounded-md text-white bg-pink-500 hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-300 transition duration-150 ease-in-out" style="margin-top: 2px;">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="text-sm text-white/90 hover:text-white font-medium transition">Login</a>
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-white/30 text-sm font-medium rounded-md text-white bg-white/20 hover:bg-white/30 backdrop-blur-sm transition">Register</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-6 flex-1">
            <div class="mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-pink-100 border border-pink-400 text-pink-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="text-white flex-shrink-0 mt-auto" style="background: #E91E63;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Main Footer Content -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <!-- Logo Ovaltin & Alamat -->
                    <div>
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('images/foto logo.webp') }}" alt="Ovaltin Logo" class="w-10 h-10 object-cover rounded-full mr-3">
                            <span class="text-3xl font-bold">Ovaltin</span>
                        </div>
                        <div class="space-y-1 text-white/90">
                            <div>Desa Lebakmuncang, Kabupaten Bandung, Jawa Barat, Indonesia</div>
                        </div>
                    </div>
                    <!-- Kontak -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-white">Kontak Kami</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-white/90">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>+62 856-0345-4924</span>
                            </div>
                            <div class="flex items-center text-white/90">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>info@ovaltin.com</span>
                            </div>
                        </div>
                    </div>

                    <!-- Layanan -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-white">Layanan</h3>
                        <ul class="space-y-3">
                            <li><a href="{{ route('user.products.index') }}" class="text-white/90 hover:text-white transition duration-200">Produk</a></li>
                            <li><a href="{{ route('testimonials.index') }}" class="text-white/90 hover:text-white transition duration-200">Testimoni</a></li>
                            <li><a href="#" class="text-white/90 hover:text-white transition duration-200">Pemesanan</a></li>
                        </ul>
                    </div>

                    <!-- Media Sosial -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-white">Ikuti Kami di Media Sosial</h3>
                        <div class="flex space-x-4">
                            <!-- Instagram -->
                            <a href="https://www.instagram.com/dapur.ovaltin/" target="_blank" class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-full hover:bg-white/30 hover:scale-110 transition duration-200 border border-white/30">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            
                            <!-- WhatsApp -->
                            <a href="https://wa.me/6285603454924" target="_blank" rel="noopener" class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-full hover:bg-white/30 hover:scale-110 transition duration-200 border border-white/30">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                            </a>
                            
                            <!-- TikTok -->
                            <a href="https://www.tiktok.com/@dapur_ovaltin?_t=8gilzzPgcCX&_r=1" target="_blank" class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-full hover:bg-white/30 hover:scale-110 transition duration-200 border border-white/30">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-.88-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>
                                </svg>
                            </a>
                            
                            <!-- YouTube -->
                            <a href="https://www.youtube.com/@dapurovaltinLM" target="_blank" class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-full hover:bg-white/30 hover:scale-110 transition duration-200 border border-white/30">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="pt-8 border-t border-white/30 text-center">
                    <p class="text-white/90 text-sm mb-2">(c) {{ date('Y') }} Ovaltin. Hak Cipta Dilindungi.</p>
                    <p class="text-white/80 text-xs">Dibuat dengan cinta untuk para pecinta strawberry Indonesia</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
