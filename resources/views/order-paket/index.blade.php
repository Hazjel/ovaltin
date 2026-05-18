@extends('layouts.app')

@section('title', 'Order Paketan')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4"
    x-data="{
        items: [],
        addProduct(id, name, price) {
            let existing = this.items.find(i => i.product_id == id);
            if (existing) { existing.qty += 10; }
            else { this.items.push({ product_id: id, product_name: name, price_per_unit: price, qty: 10 }); }
        },
        removeItem(index) { this.items.splice(index, 1); },
        increaseQty(index) { this.items[index].qty += 10; },
        decreaseQty(index) { if (this.items[index].qty > 10) this.items[index].qty -= 10; },
        get total() { return this.items.reduce((s, i) => s + i.price_per_unit * i.qty, 0); },
        formatRp(n) { return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
    }">

    <h1 class="text-2xl font-bold text-gray-900 mb-2">Order Paketan</h1>
    <p class="text-gray-500 text-sm mb-6">Minimum 10 pcs per produk, kelipatan 10. Bayar via QRIS, upload bukti transfer.</p>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Product Picker -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
        <h2 class="font-semibold text-gray-800 mb-4">Pilih Produk</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($products as $product)
                <button type="button"
                    @click="addProduct({{ $product->id }}, {{ json_encode($product->name) }}, {{ $product->price }})"
                    class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-pink-400 hover:bg-pink-50 text-left transition-colors">
                    @if($product->image)
                        <img src="{{ $product->image_url }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-pink-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                        <div class="text-xs text-pink-600 font-semibold">{{ $product->formatted_price }}</div>
                    </div>
                    <div class="ml-auto">
                        <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Order Summary -->
    <div x-show="items.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
        <h2 class="font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
        <div class="space-y-3">
            <template x-for="(item, index) in items" :key="index">
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900" x-text="item.product_name"></div>
                        <div class="text-xs text-gray-500" x-text="formatRp(item.price_per_unit) + ' / pcs'"></div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="decreaseQty(index)"
                            class="w-7 h-7 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 hover:bg-gray-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <span class="text-sm font-semibold w-10 text-center" x-text="item.qty + ' pcs'"></span>
                        <button type="button" @click="increaseQty(index)"
                            class="w-7 h-7 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 hover:bg-gray-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </button>
                    </div>
                    <div class="text-sm font-semibold text-gray-900 w-24 text-right" x-text="formatRp(item.price_per_unit * item.qty)"></div>
                    <button type="button" @click="removeItem(index)" class="text-red-400 hover:text-red-600 ml-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
            <span class="font-semibold text-gray-700">Total</span>
            <span class="text-lg font-bold text-pink-600" x-text="formatRp(total)"></span>
        </div>
    </div>

    <!-- QRIS Payment Info -->
    <div x-show="items.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
        <h2 class="font-semibold text-gray-800 mb-4">Pembayaran via QRIS</h2>
        <div class="flex flex-col items-center gap-3">
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center">
                <img src="{{ asset('images/qris-placeholder.svg') }}"
                    alt="QRIS Dapur Ovaltin"
                    class="mx-auto w-48 h-48 object-contain"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                <div style="display:none" class="w-48 h-48 mx-auto flex-col items-center justify-center gap-2 bg-gray-100 rounded-lg">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    <span class="text-sm text-gray-500">QRIS akan segera tersedia</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 text-center">Scan QRIS di atas menggunakan aplikasi dompet digital / m-banking Anda, lalu upload bukti pembayaran di formulir di bawah.</p>
        </div>
    </div>

    <!-- Order Form -->
    <div x-show="items.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <h2 class="font-semibold text-gray-800 mb-4">Data Pemesan</h2>
        <form action="{{ route('order-paket.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Hidden items fields -->
            <template x-for="(item, index) in items" :key="index">
                <span>
                    <input type="hidden" :name="`items[${index}][product_id]`" :value="item.product_id">
                    <input type="hidden" :name="`items[${index}][qty]`" :value="item.qty">
                </span>
            </template>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="Nama pemesan">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="0812xxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat (opsional)</label>
                    <textarea name="customer_address" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="Alamat pengiriman jika diperlukan">{{ old('customer_address') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran <span class="text-red-500">*</span></label>
                    <input type="file" name="payment_proof" accept="image/*" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <p class="text-xs text-gray-500 mt-1">Upload screenshot bukti transfer QRIS (JPG/PNG, maks 5MB)</p>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3">
                <button type="submit"
                    style="background:#E91E63; color:white;"
                    class="w-full py-3 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
                    Kirim Order
                </button>
                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, saya ingin konfirmasi order paketan Dapur Ovaltin.') }}"
                    target="_blank"
                    class="w-full py-3 rounded-lg text-sm font-semibold text-center border border-green-500 text-green-700 hover:bg-green-50 transition-colors">
                    Hubungi via WhatsApp
                </a>
            </div>
        </form>
    </div>

    <!-- Empty state -->
    <div x-show="items.length === 0" class="text-center py-12 text-gray-400">
        <svg class="w-16 h-16 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        <p class="text-sm">Pilih produk di atas untuk mulai order</p>
    </div>

</div>
@endsection
