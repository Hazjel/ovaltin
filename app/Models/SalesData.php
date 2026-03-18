<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesData extends Model
{
    protected $fillable = [
        'tanggal_penjualan',
        'strawberry_product_id',
        'nama_produk',
        'jumlah_terjual',
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'jumlah_terjual' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(StrawberryProduct::class, 'strawberry_product_id');
    }

    public static function getAvailableProducts()
    {
        return StrawberryProduct::query()
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public static function getAvailableProductNames(): array
    {
        return self::getAvailableProducts()
            ->pluck('name')
            ->map(fn ($name) => trim((string) $name))
            ->filter()
            ->unique(fn ($name) => strtolower($name))
            ->values()
            ->all();
    }
}
