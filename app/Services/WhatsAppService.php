<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('services.whatsapp.url', 'http://127.0.0.1:3000'), '/') . '/send-message';
    }

    /**
     * Kirim pesan WhatsApp via local Baileys API
     */
    public function send(string $phone, string $message, string $type = 'test'): bool
    {
        $status = 'gagal';
        $errorMessage = null;

        try {
            $response = Http::withHeaders([
                'X-Api-Key' => config('services.whatsapp.api_key'),
            ])->post($this->apiUrl, [
                'phone'   => $phone,
                'message' => $message,
            ]);

            $body = $response->json();

            if ($response->successful() && isset($body['success']) && $body['success'] === true) {
                Log::info("[WhatsApp] Pesan berhasil dikirim ke {$phone}");
                $status = 'sukses';
            } else {
                $errorMessage = isset($body['error']) ? $body['error'] : json_encode($body);
                Log::warning("[WhatsApp] Gagal kirim ke {$phone}: " . $errorMessage);
            }

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            Log::error("[WhatsApp] Error: " . $errorMessage);
        }

        // Simpan log riwayat ke database
        try {
            \App\Models\NotificationLog::create([
                'recipient_phone' => $phone,
                'type'            => $type,
                'message'         => $message,
                'status'          => $status,
                'error_message'   => $errorMessage,
                'sent_at'         => now(),
            ]);
        } catch (\Exception $dbEx) {
            Log::error("[WhatsApp] Gagal menyimpan log notifikasi ke database: " . $dbEx->getMessage());
        }

        return $status === 'sukses';
    }

    /**
     * Kirim pengingat data penjualan menggunakan template dari settings
     */
    public function sendSalesReminder(string $phone, string $tanggal, string $waktu = 'pagi', ?\App\Models\NotificationSetting $settings = null): bool
    {
        if ($settings) {
            $message = $settings->getMessageTemplate($tanggal, $waktu);
        } else {
            $appUrl = config('app.url', 'http://127.0.0.1:8000');
            $emoji   = $waktu === 'pagi' ? '🌅' : '🌙';
            $sapaan  = $waktu === 'pagi' ? 'Selamat pagi' : 'Selamat malam';

            $message = "🍓 *Pengingat Dapur Ovaltin*\n\n"
                . "{$emoji} {$sapaan}, Admin!\n\n"
                . "Data penjualan untuk minggu ini (*{$tanggal}*) belum diisi.\n\n"
                . "Silakan login dan isi data penjualan di:\n"
                . "👉 {$appUrl}/sales-data\n\n"
                . "Terima kasih! 🌟";
        }

        return $this->send($phone, $message, $waktu);
    }

    /**
     * Kirim pesan test — isi pesan sama dengan pengingat asli
     */
    public function sendTest(string $phone, ?\App\Models\NotificationSetting $settings = null): bool
    {
        $tanggal = now()->translatedFormat('l, d F Y');
        $waktu   = now()->hour < 12 ? 'pagi' : 'malam';

        if ($settings) {
            $message = $settings->getMessageTemplate($tanggal, $waktu);
        } else {
            $appUrl  = config('app.url', 'http://127.0.0.1:8000');
            $emoji   = $waktu === 'pagi' ? '🌅' : '🌙';
            $sapaan  = $waktu === 'pagi' ? 'Selamat pagi' : 'Selamat malam';

            $message = "🍓 *Pengingat Dapur Ovaltin*\n\n"
                . "{$emoji} {$sapaan}, Admin!\n\n"
                . "Data penjualan untuk minggu ini (*{$tanggal}*) belum diisi.\n\n"
                . "Silakan login dan isi data penjualan di:\n"
                . "👉 {$appUrl}/sales-data\n\n"
                . "Terima kasih! 🌟";
        }

        return $this->send($phone, $message, 'test');
    }
}
