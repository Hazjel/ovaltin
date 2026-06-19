<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\NotificationSetting;
use App\Models\SalesConfirmation;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class SendSalesReminder extends Command
{
    protected $signature   = 'notify:sales-reminder';
    protected $description = 'Kirim notifikasi WA pengingat data penjualan sesuai jadwal';

    public function handle(WhatsAppService $wa): int
    {
        $now     = now();
        $dayOfWeek = $now->dayOfWeek; // 0=Minggu, 1=Senin, etc.
        $timeNow = $now->format('H:i');

        // Ambil pengaturan notifikasi
        $settings = NotificationSetting::getSettings();

        if (! $settings->is_active) {
            $this->info('Notifikasi dinonaktifkan oleh admin.');
            return self::SUCCESS;
        }

        // Cek hari target pengiriman
        $targetDays = $settings->target_days ?? ['2', '5'];
        if (! in_array((string) $dayOfWeek, $targetDays)) {
            $this->info('Hari ini tidak dijadwalkan untuk pengiriman notifikasi. Notifikasi dilewati.');
            return self::SUCCESS;
        }

        // Tentukan waktu pengiriman (pagi/malam)
        $morningTime = $settings->morning_time; // default 10:00
        $eveningTime = $settings->evening_time; // default 20:00

        $isTimeToSend = ($timeNow === $morningTime || $timeNow === $eveningTime);
        $waktu        = ($timeNow === $morningTime) ? 'pagi' : 'malam';

        if (! $isTimeToSend) {
            $this->info("Bukan waktu kirim ({$morningTime} atau {$eveningTime}). Sekarang: {$timeNow}");
            return self::SUCCESS;
        }

        // Cek apakah minggu ini sudah dikonfirmasi "tidak ada penjualan" via popup
        $weekKey = $now->format('Y-\WW');
        if (SalesConfirmation::isWeekConfirmedNoSales($weekKey)) {
            $this->info('Admin sudah konfirmasi tidak ada penjualan minggu ini. Notifikasi dilewati.');
            return self::SUCCESS;
        }

        // Cek apakah ada data penjualan minggu ini di database
        if (SalesConfirmation::hasSalesDataThisWeek()) {
            $this->info('Data penjualan minggu ini sudah ada. Notifikasi dilewati.');
            return self::SUCCESS;
        }

        // Kirim notifikasi WA
        $tanggal = $now->translatedFormat('l, d F Y');
        $phone   = $settings->recipient_phone;

        $this->info("Mengirim pengingat ke {$phone} ({$waktu})...");

        $sent = $wa->sendSalesReminder($phone, $tanggal, $waktu, $settings);

        if ($sent) {
            $settings->update(['last_sent_at' => $now]);
            $this->info('✅ Notifikasi berhasil dikirim!');
            Log::info("[SalesReminder] Pengingat {$waktu} dikirim ke {$phone} pada {$now}");
        } else {
            $this->error('❌ Gagal mengirim notifikasi. Cek log untuk detail.');
        }

        return self::SUCCESS;
    }
}
