@extends('layouts.app')

@section('title', 'Kelola Informasi Kontak')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Kelola Informasi Kontak
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Kelola informasi kontak yang ditampilkan di halaman kontak website
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">

            <a href="{{ route('contact.index') }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Lihat Halaman Kontak
            </a>
        </div>
    </div>

    <!-- Contact Info Card -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Kontak Aktif</h3>
                @if($contactInfo)
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                        <a href="{{ route('admin.contact.edit', $contactInfo->id) }}" class="text-pink-600 hover:text-pink-500 text-sm font-medium">
                            Edit
                        </a>
                    </div>
                @endif
            </div>

            @if($contactInfo)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Company Info -->
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Nama Perusahaan</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $contactInfo->company_name }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Alamat</h4>
                            <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $contactInfo->address }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Deskripsi</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $contactInfo->description }}</p>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Telepon Utama</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $contactInfo->phone_primary ?? '-' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Telepon Sekunder</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $contactInfo->phone_secondary ?? '-' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Email Utama</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $contactInfo->email_primary ?? '-' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Email Sekunder</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $contactInfo->email_secondary ?? '-' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">WhatsApp</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $contactInfo->whatsapp ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Jam Operasional</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500">Senin - Jumat</p>
                            <p class="text-sm font-medium text-gray-900">{{ $contactInfo->formatted_business_hours['monday_friday'] }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500">Sabtu</p>
                            <p class="text-sm font-medium text-gray-900">{{ $contactInfo->formatted_business_hours['saturday'] }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500">Minggu</p>
                            <p class="text-sm font-medium text-gray-900">{{ $contactInfo->formatted_business_hours['sunday'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Map URL -->
                @if($contactInfo->map_embed_url)
                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">URL Peta</h4>
                    <p class="text-sm text-gray-900 break-all">{{ $contactInfo->map_embed_url }}</p>
                </div>
                @endif
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada informasi kontak</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat informasi kontak pertama.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.contact.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Kontak
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- All Contact Infos -->
    @if(\App\Models\ContactInfo::count() > 1)
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Semua Informasi Kontak</h3>
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Perusahaan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\ContactInfo::latest()->get() as $contact)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $contact->company_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($contact->is_active)
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
                                {{ $contact->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.contact.edit', $contact->id) }}" class="text-pink-600 hover:text-pink-500">Edit</a>
                                @if(!$contact->is_active)
                                    <form action="{{ route('admin.contact.set-active', $contact->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-500">Aktifkan</button>
                                    </form>
                                    <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi kontak ini?')">
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
