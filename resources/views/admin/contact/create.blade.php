@extends('layouts.app')

@section('title', 'Tambah Informasi Kontak')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Tambah Informasi Kontak
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Buat informasi kontak baru untuk ditampilkan di halaman kontak website
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('admin.contact.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.contact.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Nama Perusahaan</label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm @error('company_name') border-red-500 @enderror"
                        placeholder="Ovaltin">
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="address" id="address" rows="4" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm @error('address') border-red-500 @enderror"
                        placeholder="Desa Lebakmuncang, Kabupaten Bandung, Jawa Barat, Indonesia">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone Primary -->
                    <div>
                        <label for="phone_primary" class="block text-sm font-medium text-gray-700">Telepon Utama</label>
                        <input type="text" name="phone_primary" id="phone_primary" value="{{ old('phone_primary') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm @error('phone_primary') border-red-500 @enderror"
                            placeholder="+62 856-0345-4924">
                        @error('phone_primary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Secondary -->
                    <div>
                        <label for="phone_secondary" class="block text-sm font-medium text-gray-700">Telepon Sekunder</label>
                        <input type="text" name="phone_secondary" id="phone_secondary" value="{{ old('phone_secondary') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm @error('phone_secondary') border-red-500 @enderror"
                            placeholder="+62 856-0345-4924">
                        @error('phone_secondary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Primary -->
                    <div>
                        <label for="email_primary" class="block text-sm font-medium text-gray-700">Email Utama</label>
                        <input type="email" name="email_primary" id="email_primary" value="{{ old('email_primary') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm @error('email_primary') border-red-500 @enderror"
                            placeholder="info@ovaltin.com">
                        @error('email_primary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Secondary -->
                    <div>
                        <label for="email_secondary" class="block text-sm font-medium text-gray-700">Email Sekunder</label>
                        <input type="email" name="email_secondary" id="email_secondary" value="{{ old('email_secondary') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm @error('email_secondary') border-red-500 @enderror"
                            placeholder="order@ovaltin.com">
                        @error('email_secondary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm @error('whatsapp') border-red-500 @enderror"
                            placeholder="+62 856-0345-4924">
                        @error('whatsapp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Map Embed URL -->
                    <div>
                        <label for="map_embed_url" class="block text-sm font-medium text-gray-700">URL Peta Google Maps</label>
                        <input type="url" name="map_embed_url" id="map_embed_url" value="{{ old('map_embed_url') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm @error('map_embed_url') border-red-500 @enderror"
                            placeholder="https://maps.google.com/maps?q=-7.114057,107.422775&hl=id&z=17&output=embed">
                        @error('map_embed_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Business Hours -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Jam Operasional</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="monday_friday" class="block text-sm font-medium text-gray-700">Senin - Jumat</label>
                            <input type="text" name="monday_friday" id="monday_friday" value="{{ old('monday_friday', '08:00 - 17:00') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                                placeholder="08:00 - 17:00">
                        </div>
                        <div>
                            <label for="saturday" class="block text-sm font-medium text-gray-700">Sabtu</label>
                            <input type="text" name="saturday" id="saturday" value="{{ old('saturday', '08:00 - 15:00') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                                placeholder="08:00 - 15:00">
                        </div>
                        <div>
                            <label for="sunday" class="block text-sm font-medium text-gray-700">Minggu</label>
                            <input type="text" name="sunday" id="sunday" value="{{ old('sunday', '09:00 - 14:00') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
                                placeholder="09:00 - 14:00">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm @error('description') border-red-500 @enderror"
                        placeholder="Ada pertanyaan tentang produk strawberry kami? Ingin memesan dalam jumlah besar? Jangan ragu untuk menghubungi tim Ovaltin!">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan informasi kontak ini
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Informasi Kontak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
