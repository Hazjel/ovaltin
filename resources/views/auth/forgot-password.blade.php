<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - Ovaltin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="flex flex-col items-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-pink-600 rounded-full flex items-center justify-center mb-4">
                    <img src="{{ asset('images/foto logo.webp') }}" alt="Ovaltin" class="w-10 h-10 object-cover rounded-full">
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Lupa Password</h1>
                <p class="text-sm text-gray-500 mt-1 text-center">Masukkan email Anda, kami akan kirim link reset password.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email" required autofocus
                            value="{{ old('email') }}"
                            placeholder="Masukkan email akun Anda"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-pink-500 to-pink-600 text-white py-3 rounded-lg font-medium hover:from-pink-600 hover:to-pink-700 transition duration-200">
                        Kirim Link Reset Password
                    </button>
                </form>

                <div class="mt-5 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-pink-600 hover:text-pink-500 font-medium">
                        Kembali ke halaman login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
