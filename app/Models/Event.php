<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'type', 'banner', 'start_date', 'end_date',
        'location', 'online_url', 'max_participants', 'is_featured', 'is_paid',
        'price', 'speakers', 'qrcode_token'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'speakers' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($event) {
            $event->slug = Str::slug($event->title);
            $event->qrcode_token = Str::random(32);
        });
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
}