@extends('layouts.app')

@section('title', 'Edit FAQ')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Edit FAQ
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Edit FAQ yang sudah ada
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
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
            <form action="{{ route('admin.faqs.update', $faq) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Question -->
                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                    <input type="text" name="question" id="question" value="{{ old('question', $faq->question) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-sky-500 sm:text-sm @error('question') border-red-500 @enderror"
                        placeholder="Apa saja jenis strawberry yang tersedia?">
                    @error('question')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Answer -->
                <div>
                    <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban</label>
                    <textarea name="answer" id="answer" rows="6" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-sky-500 sm:text-sm @error('answer') border-red-500 @enderror"
                        placeholder="Kami menyediakan berbagai jenis strawberry berkualitas tinggi, termasuk strawberry organik dan strawberry premium...">{{ old('answer', $faq->answer) }}</textarea>
                    @error('answer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700">Urutan Tampil</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $faq->order) }}" min="0"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-sky-500 sm:text-sm @error('order') border-red-500 @enderror"
                        placeholder="0">
                    <p class="mt-1 text-sm text-gray-500">Urutan untuk menampilkan FAQ. Angka lebih kecil akan ditampilkan lebih dulu.</p>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan FAQ ini
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Perbarui FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

