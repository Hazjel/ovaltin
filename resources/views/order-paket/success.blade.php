@extends('layouts.app')

@section('title', 'Order Berhasil Dikirim')

@section('content')
<div class="max-w-md mx-auto py-16 px-4 text-center">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background:#dcfce7;">
        <svg class="w-10 h-10" style="color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Order Terkirim!</h1>
    <p class="text-gray-500 mb-8">Order paketan Anda sudah kami terima. Admin akan segera mengkonfirmasi setelah bukti pembayaran diverifikasi.</p>
    <div class="flex flex-col gap-3">
        <a href="{{ route('order-paket.index') }}"
            style="background:#E91E63; color:white;"
            class="w-full py-3 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity text-center">
            Order Lagi
        </a>
        <a href="{{ route('dashboard') }}"
            class="w-full py-3 rounded-lg text-sm font-semibold text-center border border-gray-300 text-gray-700 hover:bg-gray-50">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
