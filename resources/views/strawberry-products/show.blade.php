@extends('layouts.app')

@section('title', 'Detail Produk Stroberi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Detail Produk Stroberi
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Informasi lengkap produk: {{ $strawberryProduct->name }}
                </p>
            </div>
            <div class="mt-4 flex space-x-3 md:mt-0 md:ml-4">
                <a href="{{ route('strawberry-products.edit', $strawberryProduct) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('strawberry-products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Product Details -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Product Image -->
                    <div>
                        @if($strawberryProduct->image)
                            <img class="w-full h-64 object-cover rounded-lg" src="{{ Storage::url($strawberryProduct->image) }}" alt="{{ $strawberryProduct->name }}">
                        @else
                            <div class="w-full h-64 bg-pink-100 rounded-lg flex items-center justify-center">
                                <svg class="w-24 h-24 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Product Information -->
                    <div class="space-y-6">
                        <!-- Basic Info -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Produk</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $strawberryProduct->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $strawberryProduct->category }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Harga</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-semibold text-pink-600">{{ $strawberryProduct->formatted_price }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Stok</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $strawberryProduct->stock_status_color }}">
                                            {{ $strawberryProduct->stock_quantity }} unit
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Asal Produk</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $strawberryProduct->origin }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Panen</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $strawberryProduct->harvest_date->format('d M Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status Organik</dt>
                                    <dd class="mt-1">
                                        @if($strawberryProduct->is_organic)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Organik
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Non-Organik
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Description -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h3>
                            <p class="text-sm text-gray-700">{{ $strawberryProduct->description }}</p>
                        </div>

                        @if($strawberryProduct->tokopedia_url || $strawberryProduct->shopee_url || $strawberryProduct->lazada_url)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Link Marketplace</h3>
                                <div class="flex flex-wrap gap-3">
                                    @if($strawberryProduct->tokopedia_url)
                                        <a href="{{ $strawberryProduct->tokopedia_url }}" target="_blank" rel="noopener"
                                            class="inline-flex items-center px-3 py-2 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-100 hover:bg-emerald-100 text-sm font-medium">
                                            Tokopedia
                                        </a>
                                    @endif
                                    @if($strawberryProduct->shopee_url)
                                        <a href="{{ $strawberryProduct->shopee_url }}" target="_blank" rel="noopener"
                                            class="inline-flex items-center px-3 py-2 rounded-md bg-orange-50 text-orange-800 border border-orange-100 hover:bg-orange-100 text-sm font-medium">
                                            Shopee
                                        </a>
                                    @endif
                                    @if($strawberryProduct->lazada_url)
                                        <a href="{{ $strawberryProduct->lazada_url }}" target="_blank" rel="noopener"
                                            class="inline-flex items-center px-3 py-2 rounded-md bg-pink-50 text-pink-800 border border-pink-100 hover:bg-pink-100 text-sm font-medium">
                                            Lazada
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Nutritional Info -->
                        @if($strawberryProduct->nutritional_info)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Nutrisi</h3>
                                <p class="text-sm text-gray-700">{{ $strawberryProduct->nutritional_info }}</p>
                            </div>
                        @endif

                        <!-- Timestamps -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Sistem</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $strawberryProduct->created_at->format('d M Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $strawberryProduct->updated_at->format('d M Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('strawberry-products.edit', $strawberryProduct) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Produk
                    </a>
                    <form action="{{ route('strawberry-products.destroy', $strawberryProduct) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
