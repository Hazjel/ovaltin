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

    // Daftar produk yang tersedia
    public static function getAvailableProducts()
    {
        return ['Agar', 'Dodol', 'Krupuk', 'Selai'];
    }
}
