@extends('layouts.app')

@section('title', 'Kelola Pengenalan Produk')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Kelola Pengenalan Produk
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola informasi pengenalan produk yang ditampilkan di dashboard
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
            <a href="{{ route('admin.product-introduction.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Baru
            </a>
            <a href="{{ route('dashboard') }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Lihat Dashboard
            </a>
        </div>
    </div>

    <!-- Active Introduction -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Pengenalan Produk Aktif</h3>
                @if($introduction)
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                        <a href="{{ route('admin.product-introduction.edit', $introduction->id) }}" class="text-pink-600 hover:text-pink-500 text-sm font-medium">
                            Edit
                        </a>
                    </div>
                @endif
            </div>

            @if($introduction)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Content -->
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Judul</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $introduction->title }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Deskripsi</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $introduction->description }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Konten</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ Str::limit($introduction->content, 200) }}</p>
                        </div>
                    </div>

                    <!-- Features & Image -->
                    <div class="space-y-4">
                        @if($introduction->feature_1_title)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Fitur 1</h4>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $introduction->feature_1_title }}</p>
                            <p class="text-sm text-gray-600">{{ $introduction->feature_1_description }}</p>
                        </div>
                        @endif

                        @if($introduction->feature_2_title)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Fitur 2</h4>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $introduction->feature_2_title }}</p>
                            <p class="text-sm text-gray-600">{{ $introduction->feature_2_description }}</p>
                        </div>
                        @endif

                        @if($introduction->image_path)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Gambar</h4>
                            <img src="{{ $introduction->image_url }}" alt="{{ $introduction->title }}" class="w-full h-48 object-cover rounded-lg">
                        </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pengenalan produk</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat pengenalan produk pertama.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.product-introduction.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Pengenalan Produk
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- All Introductions -->
    @if(\App\Models\ProductIntroduction::count() > 1)
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Semua Pengenalan Produk</h3>
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\ProductIntroduction::latest()->get() as $intro)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $intro->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($intro->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $intro->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.product-introduction.edit', $intro->id) }}" class="text-pink-600 hover:text-pink-500">Edit</a>
                                @if(!$intro->is_active)
                                    <form action="{{ route('admin.product-introduction.set-active', $intro->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-500">Aktifkan</button>
                                    </form>
                                    <form action="{{ route('admin.product-introduction.destroy', $intro->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengenalan produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-pink-600 hover:text-pink-500">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

