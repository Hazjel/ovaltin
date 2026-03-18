<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrawberryProduct extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'category',
        'image',
        'origin',
        'harvest_date',
        'quality_grade',
        'is_organic',
        'nutritional_info',
        'status',
        'tokopedia_url',
        'shopee_url',
        'lazada_url',
        'whatsapp_url'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'harvest_date' => 'date',
        'is_organic' => 'boolean',
    ];

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity == 0) {
            return 'Out of Stock';
        } elseif ($this->stock_quantity < 10) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }

    public function getStockStatusColorAttribute()
    {
        if ($this->stock_quantity == 0) {
            return 'text-red-600 bg-red-100';
        } elseif ($this->stock_quantity < 10) {
            return 'text-yellow-600 bg-yellow-100';
        } else {
            return 'text-green-600 bg-green-100';
        }
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'active' => 'Tersedia',
            'inactive' => 'Tidak Tersedia',
            'out_of_stock' => 'Tidak Tersedia',
            default => 'Tidak Diketahui'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'text-green-600 bg-green-100',
            'inactive' => 'text-gray-600 bg-gray-100',
            'out_of_stock' => 'text-red-600 bg-red-100',
            default => 'text-gray-600 bg-gray-100'
        };
    }
}
