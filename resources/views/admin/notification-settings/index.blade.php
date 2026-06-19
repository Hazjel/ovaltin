@extends('layouts.app')

@section('title', 'Pengaturan Notifikasi WhatsApp')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                🔔 Pengaturan Notifikasi WhatsApp
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Konfigurasi pengingat otomatis data penjualan via WhatsApp
            </p>
        </div>
    </div>

    {{-- Alert success/error --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <span>❌</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <span>ℹ️</span>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    {{-- Status Card --}}
    <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="text-2xl">📊</span> Status Notifikasi
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500 mb-1">Status</p>
                @if($settings->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        ✅ Aktif
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        ❌ Nonaktif
                    </span>
                @endif
            </div>
            @php
                $daysMap = [
                    '0' => 'Minggu',
                    '1' => 'Senin',
                    '2' => 'Selasa',
                    '3' => 'Rabu',
                    '4' => 'Kamis',
                    '5' => 'Jumat',
                    '6' => 'Sabtu',
                ];
                $selectedDays = array_map(function($d) use ($daysMap) {
                    return $daysMap[$d] ?? $d;
                }, $settings->target_days ?? ['2', '5']);
            @endphp
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500 mb-1">Jadwal Kirim</p>
                <p class="font-semibold text-gray-900">
                    {{ implode(', ', $selectedDays) }}<br>
                    <span class="text-sm text-gray-600">{{ $settings->morning_time }} & {{ $settings->evening_time }}</span>
                </p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500 mb-1">Terakhir Dikirim</p>
                <p class="font-semibold text-gray-900 text-sm">
                    {{ $settings->last_sent_at ? $settings->last_sent_at->translatedFormat('d M Y H:i') : 'Belum pernah' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Form Pengaturan --}}
    <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <span class="text-2xl">⚙️</span> Konfigurasi
        </h3>

        <form action="{{ route('admin.notification-settings.update', $settings->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nomor WA --}}
            <div>
                <label for="recipient_phone" class="block text-sm font-medium text-gray-700 mb-1">
                    📱 Nomor WhatsApp Penerima
                </label>
                <input
                    type="text"
                    id="recipient_phone"
                    name="recipient_phone"
                    value="{{ old('recipient_phone', $settings->recipient_phone) }}"
                    placeholder="6289652179403"
                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                >
                <p class="mt-1 text-xs text-gray-500">Format: 62xxx (tanpa + atau 0 di depan). Contoh: 6289652179403</p>
                @error('recipient_phone')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Hari Pengiriman --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📅 Hari Pengiriman Notifikasi
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    @php
                        $daysList = [
                            '1' => 'Senin',
                            '2' => 'Selasa',
                            '3' => 'Rabu',
                            '4' => 'Kamis',
                            '5' => 'Jumat',
                            '6' => 'Sabtu',
                            '0' => 'Minggu',
                        ];
                        $savedDays = $settings->target_days ?? ['2', '5'];
                    @endphp
                    @foreach($daysList as $key => $name)
                        <div class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                id="day_{{ $key }}"
                                name="target_days[]"
                                value="{{ $key }}"
                                {{ in_array((string)$key, $savedDays) ? 'checked' : '' }}
                                class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                            >
                            <label for="day_{{ $key }}" class="text-sm text-gray-700 select-none">
                                {{ $name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('target_days')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jam Pagi & Malam --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="morning_time" class="block text-sm font-medium text-gray-700 mb-1">
                        🌅 Jam Pengingat Pagi
                    </label>
                    <input
                        type="time"
                        id="morning_time"
                        name="morning_time"
                        value="{{ old('morning_time', $settings->morning_time) }}"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                    >
                    @error('morning_time')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="evening_time" class="block text-sm font-medium text-gray-700 mb-1">
                        🌙 Jam Pengingat Malam (jika belum diisi)
                    </label>
                    <input
                        type="time"
                        id="evening_time"
                        name="evening_time"
                        value="{{ old('evening_time', $settings->evening_time) }}"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                    >
                    @error('evening_time')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Template Pesan --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="message_template" class="block text-sm font-medium text-gray-700">
                        💬 Template Isi Pesan WA
                    </label>
                    <button type="button" onclick="resetToDefault()"
                        class="text-xs text-blue-600 hover:text-blue-800 underline">
                        🔄 Reset ke Default
                    </button>
                </div>
                <textarea
                    id="message_template"
                    name="message_template"
                    rows="7"
                    placeholder="Kosongkan untuk pakai pesan default..."
                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm font-mono text-sm"
                >{{ old('message_template', $settings->message_template) }}</textarea>
                <div class="mt-2 bg-gray-50 rounded-lg p-3 text-xs text-gray-500">
                    <p class="font-semibold mb-1">📌 Placeholder yang bisa digunakan:</p>
                    <ul class="space-y-0.5">
                        <li><code class="bg-gray-200 px-1 rounded">{tanggal}</code> → Tanggal hari ini (contoh: Selasa, 17 Juni 2026)</li>
                        <li><code class="bg-gray-200 px-1 rounded">{sapaan}</code> → Sapaan sesuai waktu (Selamat pagi / Selamat malam)</li>
                        <li><code class="bg-gray-200 px-1 rounded">{emoji}</code> → Emoji waktu (🌅 pagi / 🌙 malam)</li>
                        <li><code class="bg-gray-200 px-1 rounded">{url}</code> → Link halaman data penjualan</li>
                    </ul>
                </div>
                @error('message_template')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Toggle Aktif --}}
            <div class="flex items-center gap-3">
                <input
                    type="hidden"
                    name="is_active"
                    value="0"
                >
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ $settings->is_active ? 'checked' : '' }}
                    class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                >
                <label for="is_active" class="text-sm font-medium text-gray-700">
                    Aktifkan notifikasi otomatis
                </label>
            </div>


            {{-- Submit --}}
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                    💾 Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    {{-- Test Send --}}
    <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center gap-2">
            <span class="text-2xl">📤</span> Kirim Pesan Test
        </h3>
        <p class="text-sm text-gray-500 mb-4">
            Kirim pesan WhatsApp test ke nomor <strong>{{ $settings->recipient_phone }}</strong> untuk memverifikasi koneksi WhatsApp Server.
        </p>
        <form action="{{ route('admin.notification-settings.test') }}" method="POST">
            @csrf
            <button type="submit"
                class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
                onclick="return confirm('Kirim pesan test ke {{ $settings->recipient_phone }}?')">
                📱 Kirim Test WA Sekarang
            </button>
        </form>
    </div>

    {{-- Riwayat Notifikasi --}}
    <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="text-2xl">📋</span> Riwayat Notifikasi
        </h3>
        @if($logs->isEmpty())
            <div class="text-center py-6 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                <span class="text-3xl block mb-2">📭</span> Belum ada riwayat pengiriman.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th scope="col" class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Penerima</th>
                            <th scope="col" class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th scope="col" class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Pesan</th>
                            <th scope="col" class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($logs as $log)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                                    {{ $log->sent_at->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">
                                    {{ $log->recipient_phone }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($log->type === 'pagi')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">🌅 Pagi</span>
                                    @elseif($log->type === 'malam')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">🌙 Malam</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">📤 Test</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 max-w-xs truncate text-gray-500" title="{{ $log->message }}">
                                    {{ Str::limit($log->message, 50) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($log->status === 'sukses')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            ● Sukses
                                        </span>
                                    @else
                                        <div class="flex flex-col">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800" title="{{ $log->error_message }}">
                                                ● Gagal
                                            </span>
                                            @if($log->error_message)
                                                <span class="text-xs text-red-500 mt-1 max-w-[200px] truncate" title="{{ $log->error_message }}">
                                                    {{ $log->error_message }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Info Cara Kerja --}}
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
        <h4 class="font-semibold text-amber-800 mb-3 flex items-center gap-2">
            <span>ℹ️</span> Cara Kerja Notifikasi
        </h4>
        <ul class="text-sm text-amber-700 space-y-2">
            <li>📅 <strong>Jadwal:</strong> Notifikasi dikirim setiap <strong>{{ implode(', ', $selectedDays) }}</strong></li>
            <li>🌅 <strong>Pagi ({{ $settings->morning_time }}):</strong> Pengingat pertama jika data belum diisi</li>
            <li>🌙 <strong>Malam ({{ $settings->evening_time }}):</strong> Pengingat kedua jika masih belum diisi</li>
            <li>🚫 <strong>Berhenti otomatis</strong> jika admin klik "Tidak ada penjualan" di popup saat buka halaman Data Penjualan</li>
            <li>✅ <strong>Berhenti otomatis</strong> jika data penjualan sudah diisi minggu ini</li>
            <li>⚙️ <strong>Dijalankan:</strong> Dengan perintah <code class="bg-amber-100 px-1 rounded">php artisan schedule:work</code></li>
        </ul>
    </div>

</div>

<script>
    function resetToDefault() {
        if (!confirm('Reset template ke pesan default? Pesan kustom akan dihapus.')) return;
        document.getElementById('message_template').value = '';
        document.getElementById('message_template').placeholder =
            'Kosongkan untuk pakai pesan default...\n\n' +
            'Contoh pesan default:\n' +
            '🍓 *Pengingat Dapur Ovaltin*\n\n' +
            '{emoji} {sapaan}, Admin!\n\n' +
            'Data penjualan untuk minggu ini (*{tanggal}*) belum diisi.\n\n' +
            'Silakan login dan isi data penjualan di:\n' +
            '👉 {url}\n\n' +
            'Terima kasih! 🌟';
    }
</script>
@endsection
