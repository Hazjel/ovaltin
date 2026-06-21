<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'recipient_phone',
        'morning_time',
        'evening_time',
        'target_days',
        'message_template',
        'is_active',
        'last_sent_at',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'last_sent_at' => 'datetime',
        'target_days'  => 'array',
    ];

    /**
     * Ambil pengaturan aktif (selalu satu baris)
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate([], [
            'recipient_phone'  => env('DEFAULT_NOTIFICATION_PHONE', ''),
            'morning_time'     => '10:00',
            'evening_time'     => '20:00',
            'target_days'      => ['2', '5'],
            'message_template' => null,
            'is_active'        => true,
        ]);
    }

    /**
     * Ambil template pesan (gunakan default jika kosong)
     */
    public function getMessageTemplate(?string $tanggal = null, string $waktu = 'pagi'): string
    {
        $appUrl = config('app.url', 'http://127.0.0.1:8000');
        $tanggal = $tanggal ?? now()->translatedFormat('l, d F Y');
        $emoji = $waktu === 'pagi' ? '🌅' : '🌙';
        $sapaan = $waktu === 'pagi' ? 'Selamat pagi' : 'Selamat malam';

        if ($this->message_template) {
            // Ganti placeholder dengan nilai aktual
            return str_replace(
                ['{tanggal}', '{sapaan}', '{emoji}', '{url}'],
                [$tanggal, $sapaan, $emoji, $appUrl . '/sales-data'],
                $this->message_template
            );
        }

        // Pesan default
        return "🍓 *Pengingat Dapur Ovaltin*\n\n"
            . "{$emoji} {$sapaan}, Admin!\n\n"
            . "Data penjualan untuk minggu ini (*{$tanggal}*) belum diisi.\n\n"
            . "Silakan login dan isi data penjualan di:\n"
            . "👉 {$appUrl}/sales-data\n\n"
            . "Terima kasih! 🌟";
    }
}
