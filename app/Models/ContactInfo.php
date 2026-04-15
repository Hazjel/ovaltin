<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $fillable = [
        'company_name',
        'address',
        'phone_primary',
        'phone_secondary',
        'email_primary',
        'email_secondary',
        'whatsapp',
        'business_hours',
        'map_embed_url',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Pastikan hanya satu contact info yang aktif di satu waktu
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
     * Get the active contact info
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first() ?? self::first();
    }

    /**
     * Get formatted business hours
     */
    public function getFormattedBusinessHoursAttribute()
    {
        if (!$this->business_hours) {
            return [
                'monday_friday' => '08:00 - 17:00',
                'saturday' => '08:00 - 15:00',
                'sunday' => '09:00 - 14:00'
            ];
        }

        return json_decode($this->business_hours, true) ?? [
            'monday_friday' => '08:00 - 17:00',
            'saturday' => '08:00 - 15:00',
            'sunday' => '09:00 - 14:00'
        ];
    }
}
