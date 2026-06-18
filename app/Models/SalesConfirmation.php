<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SalesConfirmation extends Model
{
    protected $fillable = [
        'confirmation_date',
        'has_sales',
        'week_key',
    ];

    protected $casts = [
        'confirmation_date' => 'date',
        'has_sales'         => 'boolean',
    ];

    /**
     * Cek apakah minggu ini sudah dikonfirmasi "tidak ada penjualan"
     */
    public static function isWeekConfirmedNoSales(?string $weekKey = null): bool
    {
        $weekKey = $weekKey ?? now()->format('Y-\WW');

        return self::where('week_key', $weekKey)
            ->where('has_sales', false)
            ->exists();
    }

    /**
     * Cek apakah hari ini sudah ada konfirmasi
     */
    public static function isTodayConfirmed(): bool
    {
        return self::whereDate('confirmation_date', today())->exists();
    }

    /**
     * Simpan konfirmasi hari ini
     */
    public static function confirmToday(bool $hasSales): self
    {
        return self::updateOrCreate(
            ['confirmation_date' => today()->format('Y-m-d')],
            [
                'has_sales' => $hasSales,
                'week_key'  => now()->format('Y-\WW'),
            ]
        );
    }

    /**
     * Cek apakah ada data penjualan minggu ini DI DATABASE
     */
    public static function hasSalesDataThisWeek(): bool
    {
        $startOfWeek = now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $endOfWeek   = now()->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        return SalesData::whereBetween('tanggal_penjualan', [$startOfWeek, $endOfWeek])->exists();
    }
}
