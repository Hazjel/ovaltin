@extends('layouts.app')

@section('title', 'Detail Order #' . $order->id)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back -->
    <a href="{{ route('admin.orders.index') }}"
        class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke daftar order
    </a>

    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                <p class="text-sm text-gray-500">{{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status_color }}">
                {{ $order->status_label }}
            </span>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="font-semibold text-gray-800 mb-4">Data Pemesan</h2>
        <dl class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div>
                <dt class="text-xs text-gray-500">Nama</dt>
                <dd class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-500">WhatsApp</dt>
                <dd class="text-sm font-medium text-gray-900">
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $order->customer_phone) }}"
                        target="_blank" class="text-green-600 hover:underline">
                        {{ $order->customer_phone }}
                    </a>
                </dd>
            </div>
            @if($order->customer_address)
                <div class="sm:col-span-2">
                    <dt class="text-xs text-gray-500">Alamat</dt>
                    <dd class="text-sm text-gray-900">{{ $order->customer_address }}</dd>
                </div>
            @endif
        </dl>
    </div>

    <!-- Order Items -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="font-semibold text-gray-800 mb-4">Produk Dipesan</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $item['product_name'] }}</div>
                        <div class="text-xs text-gray-500">{{ number_format($item['price_per_unit'], 0, ',', '.') }} × {{ $item['qty'] }} pcs</div>
                    </div>
                    <div class="text-sm font-semibold text-gray-900">
                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
            <div class="flex justify-between items-center pt-2">
                <span class="font-semibold text-gray-700">Total</span>
                <span class="text-lg font-bold text-pink-600">{{ $order->formatted_total }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Proof -->
    @if($order->payment_proof)
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="font-semibold text-gray-800 mb-4">Bukti Pembayaran</h2>
            <img src="{{ $order->payment_proof_url }}" alt="Bukti Transfer"
                class="max-w-full rounded-lg border border-gray-200" style="max-height: 400px; object-fit: contain;">
        </div>
    @endif

    <!-- Update Status Form -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="font-semibold text-gray-800 mb-4">Update Status</h2>
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-pink-500 focus:border-pink-500">
                        <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="confirmed"  {{ $order->status === 'confirmed'  ? 'selected' : '' }}>Dikonfirmasi</option>
                        <option value="selesai"    {{ $order->status === 'selesai'    ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin (opsional)</label>
                    <textarea name="admin_notes" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-pink-500 focus:border-pink-500"
                        placeholder="Catatan untuk internal...">{{ $order->admin_notes }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit"
                    style="background:#E91E63; color:white;"
                    class="px-6 py-2 rounded-lg text-sm font-semibold hover:opacity-90">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
