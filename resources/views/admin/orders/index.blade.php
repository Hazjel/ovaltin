@extends('layouts.app')

@section('title', 'Manajemen Order Paketan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Order Paketan</h2>
            <p class="mt-1 text-sm text-gray-500">Daftar semua order paketan masuk</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white shadow rounded-lg px-4 py-4">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Filter Status</label>
                <select name="status" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-pink-500 focus:border-pink-500">
                    <option value="">Semua Status</option>
                    <option value="pending"     {{ request('status') === 'pending'     ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="confirmed"   {{ request('status') === 'confirmed'   ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="selesai"     {{ request('status') === 'selesai'     ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan"  {{ request('status') === 'dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemesan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Bukti</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        @foreach($order->items as $item)
                                            <div>{{ $item['product_name'] }} × {{ $item['qty'] }}</div>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-4 text-center text-sm font-semibold text-gray-900">
                                        {{ $order->formatted_total }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($order->payment_proof)
                                            <a href="{{ $order->payment_proof_url }}" target="_blank"
                                                class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100 hover:bg-blue-100">
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_color }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center text-xs text-gray-500">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 hover:bg-indigo-100">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $orders->withQueryString()->links() }}</div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada order</h3>
                    <p class="mt-1 text-sm text-gray-500">Order paketan dari pelanggan akan muncul di sini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
