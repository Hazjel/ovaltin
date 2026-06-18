@extends('layouts.app')

@section('title', 'Riwayat Notifikasi In-App')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl flex items-center gap-2">
                <span>🔔</span> Riwayat Notifikasi
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Pusat informasi dan status input data penjualan Dapur Ovaltin
            </p>
        </div>
        
        @if($notifications->where('is_read', false)->count() > 0)
            <div>
                <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-white bg-pink-600 hover:bg-pink-700 shadow-sm transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tandai Semua Dibaca
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Alert success/error --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
            <span>✅</span>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Notifications List --}}
    <div class="space-y-4">
        @forelse($notifications as $item)
            @php
                $bgClass = '';
                $borderClass = 'border-gray-100';
                $iconBg = '';
                $iconColor = '';
                $iconSvg = '';

                if ($item->type === 'warning') {
                    $bgClass = 'bg-amber-50/40 hover:bg-amber-50/70';
                    $borderClass = 'border-amber-100';
                    $iconBg = 'bg-amber-100 text-amber-600';
                    // Warning icon
                    $iconSvg = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
                } elseif ($item->type === 'success') {
                    $bgClass = 'bg-emerald-50/40 hover:bg-emerald-50/70';
                    $borderClass = 'border-emerald-100';
                    $iconBg = 'bg-emerald-100 text-emerald-600';
                    // Success icon
                    $iconSvg = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                } else {
                    $bgClass = 'bg-blue-50/40 hover:bg-blue-50/70';
                    $borderClass = 'border-blue-100';
                    $iconBg = 'bg-blue-100 text-blue-600';
                    // Info icon
                    $iconSvg = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                }
            @endphp

            <div class="bg-white border {{ $borderClass }} rounded-2xl p-5 shadow-sm hover:shadow transition-all duration-200 relative overflow-hidden group">
                {{-- Decorative light background for unread --}}
                @if(!$item->is_read)
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-pink-500"></div>
                @endif
                
                <div class="flex items-start gap-4">
                    {{-- Icon type --}}
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center {{ $iconBg }} shadow-inner">
                        {!! $iconSvg !!}
                    </div>

                    {{-- Content details --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                {{ $item->title }}
                                @if(!$item->is_read)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-pink-100 text-pink-700 animate-pulse">
                                        Baru
                                    </span>
                                @endif
                            </h3>
                            <span class="text-xs text-gray-400 font-medium" title="{{ $item->created_at->translatedFormat('d F Y, H:i') }}">
                                {{ $item->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed pr-8">
                            {{ $item->message }}
                        </p>
                    </div>

                    {{-- Action link --}}
                    <div class="flex-shrink-0 self-center">
                        <a href="{{ route('admin.notifications.read', $item->id) }}" 
                           class="inline-flex items-center justify-center p-2 rounded-xl border border-gray-200 text-gray-600 bg-gray-50 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 shadow-sm transition duration-150 group-hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-gray-100 shadow rounded-2xl p-12 text-center">
                <div class="text-6xl mb-4">🍓</div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak Ada Notifikasi</h3>
                <p class="text-sm text-gray-500">
                    Sistem dalam kondisi prima dan belum ada notifikasi masuk saat ini.
                </p>
            </div>
        @endforelse

        {{-- Paginasi --}}
        @if($notifications->hasPages())
            <div class="pt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
