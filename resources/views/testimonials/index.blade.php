@extends('layouts.app')

@section('title', 'Testimoni Pelanggan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Testimoni Pelanggan</h1>
        <p class="text-lg text-gray-600">Apa kata pelanggan tentang produk strawberry kami</p>
    </div>

    <!-- Add Testimonial Button -->
    <div class="text-center">
        @auth
            @if(!Auth::user()->isAdmin())
                <a href="{{ route('testimonials.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-sky-500 to-indigo-500 text-white font-semibold rounded-lg hover:from-sky-600 hover:to-indigo-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Berikan Testimoni
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-sky-500 to-indigo-500 text-white font-semibold rounded-lg hover:from-sky-600 hover:to-indigo-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Login untuk Berikan Testimoni
            </a>
        @endauth
    </div>

    <!-- Testimonials Grid -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="p-6 sm:p-8">
            @if($testimonials->count() > 0)
                <div class="mb-6 text-center">
                    <p class="text-gray-600 text-sm">Menampilkan {{ $testimonials->count() }} testimoni dari pelanggan</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($testimonials as $testimonial)
                        <div class="bg-gradient-to-br from-sky-50 to-indigo-50 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-sky-100">
                            <!-- User Info -->
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-sky-400 to-indigo-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-bold text-gray-900">{{ $testimonial->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $testimonial->formatted_date }}</p>
                                </div>
                            </div>
                            
                            <!-- Rating -->
                            <div class="mb-4">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm font-semibold text-gray-700">{{ $testimonial->rating }}/5</span>
                                </div>
                            </div>
                            
                            <!-- Message -->
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="text-gray-700 leading-relaxed">"{{ $testimonial->message }}"</p>
                            </div>
                            
                            <!-- Verified Badge -->
                            <div class="mt-4 flex items-center justify-end">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Terverifikasi
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $testimonials->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-24 h-24 text-sky-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada testimoni</h3>
                    <p class="text-gray-500 mb-6">Jadilah yang pertama memberikan testimoni tentang produk kami!</p>
                    @auth
                        @if(!Auth::user()->isAdmin())
                            <a href="{{ route('testimonials.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-sky-500 to-indigo-500 text-white font-semibold rounded-lg hover:from-sky-600 hover:to-indigo-600 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Berikan Testimoni Pertama
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-sky-500 to-indigo-500 text-white font-semibold rounded-lg hover:from-sky-600 hover:to-indigo-600 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login untuk Berikan Testimoni
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
