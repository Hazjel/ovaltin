@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-pink-50 py-12 rounded-3xl mx-4 my-4 shadow-2xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="relative text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Hubungi Kami</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Ada pertanyaan tentang produk strawberry kami? Ingin memesan dalam jumlah besar? 
                Jangan ragu untuk menghubungi tim Ovaltin!
            </p>

            @auth
                @if(auth()->user()->isAdmin())
                    <div class="absolute top-0 right-0 z-10">
                        <a href="{{ route('admin.contact.index') }}" class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-150 shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Informasi
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Column - Contact Information Only -->
            <div>
                <div class="bg-white rounded-3xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 text-pink-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Informasi Kontak
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Alamat Kebun</h3>
                                <p class="text-gray-600">{!! nl2br(e($contactInfo->address ?? 'Desa Lebakmuncang, Kabupaten Bandung, Jawa Barat, Indonesia')) !!}</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Telepon</h3>
                                @if($contactInfo && $contactInfo->phone_primary)
                                    <p class="text-gray-600">{{ $contactInfo->phone_primary }}</p>
                                @else
                                    <p class="text-gray-600">+62 856-0345-4924</p>
                                @endif
                                @if($contactInfo && $contactInfo->phone_secondary)
                                    <p class="text-gray-600">{{ $contactInfo->phone_secondary }}</p>
                                @else
                                    <p class="text-gray-600">+62 856-0345-4924</p>
                                @endif
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Email</h3>
                                @if($contactInfo && $contactInfo->email_primary)
                                    <p class="text-gray-600">{{ $contactInfo->email_primary }}</p>
                                @else
                                    <p class="text-gray-600">info@ovaltin.com</p>
                                @endif
                                @if($contactInfo && $contactInfo->email_secondary)
                                    <p class="text-gray-600">{{ $contactInfo->email_secondary }}</p>
                                @else
                                    <p class="text-gray-600">order@ovaltin.com</p>
                                @endif
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">WhatsApp</h3>
                                @if($contactInfo && $contactInfo->whatsapp)
                                    <p class="text-gray-600">{{ $contactInfo->whatsapp }}</p>
                                @else
                                    <p class="text-gray-600">+62 856-0345-4924</p>
                                @endif
                                <p class="text-sm text-green-600">Chat langsung untuk pemesanan cepat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Business Hours - Moved to Right Top -->
                <div class="bg-white rounded-3xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 text-pink-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Jam Operasional
                    </h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Senin - Jumat</span>
                            <span class="font-semibold text-gray-900">{{ $contactInfo ? $contactInfo->formatted_business_hours['monday_friday'] : '08:00 - 17:00' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sabtu</span>
                            <span class="font-semibold text-gray-900">{{ $contactInfo ? $contactInfo->formatted_business_hours['saturday'] : '08:00 - 15:00' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Minggu</span>
                            <span class="font-semibold text-gray-900">{{ $contactInfo ? $contactInfo->formatted_business_hours['sunday'] : '09:00 - 14:00' }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-4 bg-pink-50 rounded-2xl">
                        <p class="text-sm text-pink-800">
                            <strong>Catatan:</strong> Untuk pemesanan di luar jam operasional, 
                            silakan kirim pesan WhatsApp atau email. Kami akan merespons secepatnya!
                        </p>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="bg-white rounded-3xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 text-pink-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Media Sosial
                    </h2>
                    
                    <div class="flex items-center justify-center space-x-4">
                        <!-- Instagram -->
                        <a href="{{ $contactInfo && $contactInfo->instagram_url ? $contactInfo->instagram_url : 'https://www.instagram.com/dapur.ovaltin/' }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-16 h-16 bg-gradient-to-r from-purple-500 via-pink-500 to-orange-500 rounded-full flex items-center justify-center hover:shadow-lg hover:scale-110 transition-all duration-200 group border-2 border-white shadow-md overflow-hidden">
                            <img src="{{ asset('image.png') }}" alt="Instagram" class="w-full h-full object-cover">
                        </a>

                        <!-- TikTok -->
                        <a href="{{ $contactInfo && $contactInfo->tiktok_url ? $contactInfo->tiktok_url : 'https://www.tiktok.com/@dapur_ovaltin?_t=8gilzzPgcCX&_r=1' }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-16 h-16 bg-gray-900 rounded-full flex items-center justify-center hover:shadow-lg hover:scale-110 transition-all duration-200 group border-2 border-white shadow-md">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                            </svg>
                        </a>

                        <!-- YouTube -->
                        <a href="{{ $contactInfo && $contactInfo->youtube_url ? $contactInfo->youtube_url : 'https://www.youtube.com/@dapurovaltinLM' }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center hover:shadow-lg hover:scale-110 transition-all duration-200 group border-2 border-white shadow-md">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>


        </div>
    </div>

    <!-- Map Section - Full Width -->
    <div class="mt-16 -mx-4 sm:-mx-6 lg:-mx-8">
        <div class="bg-white rounded-3xl shadow-lg p-8 mx-4 sm:mx-6 lg:mx-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Lokasi Kebun Strawberry</h2>
            <div class="bg-gray-200 rounded-2xl h-96 lg:h-[500px] flex items-center justify-center w-full">
                <iframe 
                    src="{{ $contactInfo && $contactInfo->map_embed_url ? $contactInfo->map_embed_url : 'https://maps.google.com/maps?q=-7.114057,107.422775&hl=id&z=17&output=embed' }}" 
                    width="100%" 
                    height="100%" 
                    style="border:0; border-radius: 0.5rem;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection
