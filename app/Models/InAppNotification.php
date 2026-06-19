<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InAppNotification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'link',
        'week_key',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Sinkronisasi notifikasi mingguan in-app.
     * Fungsi ini memastikan peringatan "belum input data" atau sukses "selamat anda sudah input data" ada sesuai dengan kondisi data penjualan minggu ini.
     */
    public static function syncWeeklyNotifications(): void
    {
        // Mendapatkan format key minggu saat ini (misal: 2026-W25)
        $weekKey = now()->format('Y-\WW');
        
        // Memeriksa apakah ada data penjualan untuk minggu ini
        $hasSales = SalesConfirmation::hasSalesDataThisWeek();

        if ($hasSales) {
            // Cek apakah notifikasi sukses untuk minggu ini sudah ada
            $successExists = self::where('week_key', $weekKey)
                ->where('type', 'success')
                ->exists();

            if (!$successExists) {
                // Buat notifikasi sukses
                self::create([
                    'title' => 'Input Data Sukses',
                    'message' => 'Selamat anda sudah melakukan input data',
                    'type' => 'success',
                    'link' => route('sales-data.index'),
                    'week_key' => $weekKey,
                    'is_read' => false,
                ]);

                // Tandai notifikasi peringatan minggu ini sebagai dibaca agar tidak membingungkan
                self::where('week_key', $weekKey)
                    ->where('type', 'warning')
                    ->update(['is_read' => true]);
            }
        } else {
            // Cek apakah notifikasi peringatan untuk minggu ini sudah ada
            $warningExists = self::where('week_key', $weekKey)
                ->where('type', 'warning')
                ->exists();

            if (!$warningExists) {
                // Buat notifikasi peringatan
                self::create([
                    'title' => 'Peringatan Input Data',
                    'message' => 'Anda belum memasukkan data pada minggu ini silahkan melakukan input data',
                    'type' => 'warning',
                    'link' => route('sales-data.index'),
                    'week_key' => $weekKey,
                    'is_read' => false,
                ]);

                // Hapus notifikasi sukses jika sebelumnya ada tetapi semua data penjualan dihapus
                self::where('week_key', $weekKey)
                    ->where('type', 'success')
                    ->delete();
            }
        }
    }
}
