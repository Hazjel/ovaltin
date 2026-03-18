<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesData extends Model
{
    protected $fillable = [
        'tanggal_penjualan',
        'nama_produk',
        'jumlah_terjual',
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'jumlah_terjual' => 'integer',
    ];

    // Daftar produk yang tersedia untuk input data penjualan
    public static function getAvailableProducts(): array
    {
        $strawberryProducts = StrawberryProduct::query()
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->pluck('name')
            ->map(fn ($name) => trim($name))
            ->filter()
            ->values()
            ->all();

        $historicalProducts = self::query()
            ->whereNotNull('nama_produk')
            ->where('nama_produk', '!=', '')
            ->distinct()
            ->pluck('nama_produk')
            ->map(fn ($name) => trim($name))
            ->filter()
            ->values()
            ->all();

        $products = array_values(array_unique(array_merge(
            $strawberryProducts,
            $historicalProducts,
        )));

        sort($products, SORT_NATURAL | SORT_FLAG_CASE);

        return $products;
    }
}
