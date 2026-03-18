@extends('layouts.app')

@section('title', 'Edit Pengenalan Produk')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Edit Pengenalan Produk
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi pengenalan produk
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('admin.product-introduction.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.product-introduction.update', $introduction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $introduction->title) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="2" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('description') border-red-500 @enderror">{{ old('description', $introduction->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Konten Lengkap</label>
                    <textarea name="content" id="content" rows="5" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('content') border-red-500 @enderror">{{ old('content', $introduction->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Features -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Fitur 1</h3>
                        <div>
                            <label for="feature_1_title" class="block text-sm font-medium text-gray-700">Judul Fitur 1</label>
                            <input type="text" name="feature_1_title" id="feature_1_title" value="{{ old('feature_1_title', $introduction->feature_1_title) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="feature_1_description" class="block text-sm font-medium text-gray-700">Deskripsi Fitur 1</label>
                            <textarea name="feature_1_description" id="feature_1_description" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">{{ old('feature_1_description', $introduction->feature_1_description) }}</textarea>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Fitur 2</h3>
                        <div>
                            <label for="feature_2_title" class="block text-sm font-medium text-gray-700">Judul Fitur 2</label>
                            <input type="text" name="feature_2_title" id="feature_2_title" value="{{ old('feature_2_title', $introduction->feature_2_title) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="feature_2_description" class="block text-sm font-medium text-gray-700">Deskripsi Fitur 2</label>
                            <textarea name="feature_2_description" id="feature_2_description" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">{{ old('feature_2_description', $introduction->feature_2_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                    @if($introduction->image_path)
                        <div class="mt-2 mb-4">
                            <img src="{{ $introduction->image_url }}" alt="{{ $introduction->title }}" class="h-32 w-auto object-cover rounded-lg">
                            <p class="text-sm text-gray-500 mt-1">Gambar saat ini</p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-pink-50 file:text-pink-700
                            hover:file:bg-sky-100
                            @error('image') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Upload gambar baru untuk mengubah (max 2MB)</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $introduction->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan pengenalan produk ini
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

