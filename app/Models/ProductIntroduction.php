<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductIntroduction extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content',
        'feature_1_title',
        'feature_1_description',
        'feature_2_title',
        'feature_2_description',
        'image_path',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Pastikan hanya satu intro yang aktif di satu waktu
        static::saving(function (self $model) {
            if (!$model->is_active) {
                return;
            }

            static::query()
                ->when($model->exists, fn ($q) => $q->where('id', '!=', $model->id))
                ->where('is_active', true)
                ->update(['is_active' => false]);
        });
    }

    /**
     * Get the active product introduction
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first() ?? self::first();
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('images/strawberry-farm.webp'); // default image
    }
}
