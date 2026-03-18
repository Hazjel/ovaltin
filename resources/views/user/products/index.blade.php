@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Katalog Produk Strawberry')

@section('content')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Katalog Produk Strawberry</h1>
        <p class="text-lg text-gray-600">Temukan berbagai produk strawberry berkualitas premium dari kebun kami</p>
    </div>

    <!-- Products Grid -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="p-6 sm:p-8">
            @if($products->count() > 0)
                <div class="mb-6 text-center">
                    <p class="text-gray-600 text-sm">Menampilkan {{ $products->count() }} produk strawberry tersedia</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-gradient-to-br from-pink-50 to-pink-50 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-2 border-pink-100 group flex flex-col h-full">
                            @if($product->image)
                                <div class="h-48 overflow-hidden bg-pink-100 relative">
                                    <img src="{{ Storage::url($product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                         style="display: block !important; visibility: visible !important; opacity: 1 !important; min-height: 192px; max-width: 100%;"
                                         onerror="this.onerror=null; this.style.display='none'; this.parentElement.innerHTML='<div class=\'h-48 bg-gradient-to-br from-pink-200 to-pink-200 flex items-center justify-center\'><svg class=\'w-20 h-20 text-pink-400\' fill=\'currentColor\' viewBox=\'0 0 20 20\'><path d=\'M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z\'/></svg></div>';">
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br from-pink-200 to-pink-200 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                
                                <!-- Category -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                        {{ $product->category }}
                                    </span>
                                </div>
                                
                                <!-- Price & Stock -->
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <p class="text-2xl font-bold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Per unit</p>
                                    </div>
                                    <div class="bg-gradient-to-r from-pink-100 to-pink-100 px-3 py-1 rounded-full">
                                        <p class="text-sm font-semibold text-pink-700">
                                            Stok: 
                                            @if($product->status === 'out_of_stock')
                                                <span class="text-red-600">0</span>
                                            @else
                                                {{ $product->stock_quantity }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                @if($product->status === 'out_of_stock')
                                    <div class="mb-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Habis Stok
                                        </span>
                                    </div>
                                @endif
                                
                                {{-- Daftar produk user (badge) --}}
                                <!-- Organic Badge -->
                                @if($product->is_organic)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Olahan
                                        </span>
                                    </div>
                                @endif
                                
                                <!-- View Details Button - Always at bottom -->
                                <div class="mt-auto">
                                    <a href="{{ route('user.products.show', $product) }}" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-pink-500 to-pink-500 hover:from-pink-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-24 h-24 text-pink-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada produk tersedia</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
