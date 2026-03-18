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
