<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebun Strawberry - Selamat Datang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="bg-pink-600 p-2 rounded-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-800">Kebun Strawberry</span>
                </div>
                <div class="flex space-x-4">
                    @if (Route::has('login'))
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-pink-600 transition">Dashboard Admin</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-pink-600 transition">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-pink-600 transition">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Strawberry Image -->
    <div class="relative mt-16 h-[600px] overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 to-gray-900/60 z-10"></div>
            <img src="{{ asset('images/strawberry-farm.webp') }}" 
                 alt="Kebun Strawberry" 
                 class="w-full h-full object-cover">
        </div>
        
        <!-- Hero Content -->
        <div class="relative z-20 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                        Selamat Datang di<br>
                        <span class="text-red-400">Kebun Strawberry</span>
                    </h1>
                    <p class="text-xl text-gray-200 mb-8">
                        Nikmati strawberry segar langsung dari kebun kami. Kualitas terbaik, rasa yang tak terlupakan.
                    </p>
                    <div class="flex space-x-4">
                        @guest
                            <a href="{{ route('register') }}" class="px-8 py-3 bg-pink-600 text-white rounded-lg font-semibold hover:bg-pink-700 transition transform hover:scale-105">
                                Mulai Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-gray-900 rounded-lg font-semibold hover:bg-gray-100 transition transform hover:scale-105">
                                Login
                            </a>
                        @else
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="px-8 py-3 bg-pink-600 text-white rounded-lg font-semibold hover:bg-pink-700 transition transform hover:scale-105">
                                    Ke Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-pink-600 text-white rounded-lg font-semibold hover:bg-pink-700 transition transform hover:scale-105">
                                    Ke Dashboard
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
                <p class="text-lg text-gray-600">Kami menyediakan strawberry berkualitas terbaik dengan berbagai keunggulan</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition transform hover:-translate-y-2">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">100% Segar</h3>
                    <p class="text-gray-600">Strawberry dipetik langsung dari kebun kami setiap hari untuk menjamin kesegaran maksimal.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition transform hover:-translate-y-2">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Terjangkau</h3>
                    <p class="text-gray-600">Dapatkan strawberry berkualitas premium dengan harga yang bersahabat untuk semua kalangan.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition transform hover:-translate-y-2">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pengiriman Cepat</h3>
                    <p class="text-gray-600">Sistem pengiriman yang cepat dan aman memastikan strawberry sampai dalam kondisi prima.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-pink-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Siap Menikmati Strawberry Segar?</h2>
            <p class="text-xl text-pink-100 mb-8">Bergabunglah dengan ribuan pelanggan puas kami</p>
            @guest
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-white text-pink-600 rounded-lg font-semibold hover:bg-gray-100 transition transform hover:scale-105">
                    Daftar Sekarang
                </a>
            @endguest
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Kebun Strawberry</h3>
                    <p class="text-gray-400">Menyediakan strawberry segar berkualitas terbaik sejak 2024</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Kontak</h3>
                    <p class="text-gray-400">Email: info@strawberry.com</p>
                    <p class="text-gray-400">Telepon: (021) 1234-5678</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Media Sosial</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Kebun Strawberry. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
