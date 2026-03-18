@extends('layouts.app')

@section('title', 'FAQ - Pertanyaan yang Sering Diajukan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Pertanyaan yang Sering Diajukan</h1>
        <p class="text-lg text-gray-600">Temukan jawaban untuk pertanyaan umum tentang produk strawberry kami</p>
    </div>

    <!-- FAQs Accordion -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="p-6 sm:p-8">
            @if($faqs->count() > 0)
                <div class="mb-6 text-center">
                    <p class="text-gray-600 text-sm">Menampilkan {{ $faqs->count() }} pertanyaan yang sering diajukan</p>
                </div>
                
                <div class="space-y-4">
                    @foreach($faqs as $index => $faq)
                        <div class="border-2 border-pink-100 rounded-xl overflow-hidden hover:border-pink-300 transition-all duration-200" x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }">
                            <!-- Question Header -->
                            <button 
                                @click="open = !open"
                                class="w-full px-6 py-4 bg-gradient-to-r from-pink-50 to-pink-50 hover:from-pink-100 hover:to-pink-100 transition-all duration-200 flex items-center justify-between text-left"
                            >
                                <div class="flex items-center space-x-4 flex-1">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-pink-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 flex-1">{{ $faq->question }}</h3>
                                </div>
                                <svg 
                                    class="w-6 h-6 text-pink-600 transition-transform duration-200 flex-shrink-0" 
                                    :class="{ 'rotate-180': open }"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Answer Content -->
                            <div 
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-2"
                                class="px-6 py-4 bg-white"
                            >
                                <div class="pl-12">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $faq->answer }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-24 h-24 text-pink-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada FAQ</h3>
                    <p class="text-gray-600">FAQ akan segera ditambahkan oleh admin.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Contact Support Section -->
    <div class="bg-gradient-to-r from-pink-50 to-pink-50 rounded-xl p-6 border-2 border-pink-100">
        <div class="text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Masih Ada Pertanyaan?</h3>
            <p class="text-gray-600 mb-4">Jika pertanyaan Anda belum terjawab, jangan ragu untuk menghubungi kami</p>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-500 text-white font-semibold rounded-lg hover:from-pink-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</div>
@endsection

