<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageOrder extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'items',
        'total_price',
        'payment_proof',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'items' => 'array',
        'total_price' => 'decimal:2',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'Menunggu Konfirmasi',
            'confirmed'   => 'Dikonfirmasi',
            'selesai'     => 'Selesai',
            'dibatalkan'  => 'Dibatalkan',
            default       => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'bg-yellow-100 text-yellow-800',
            'confirmed'  => 'bg-blue-100 text-blue-800',
            'selesai'    => 'bg-green-100 text-green-800',
            'dibatalkan' => 'bg-red-100 text-red-800',
            default      => 'bg-gray-100 text-gray-800',
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->payment_proof ? asset('storage/' . $this->payment_proof) : null;
    }
}
