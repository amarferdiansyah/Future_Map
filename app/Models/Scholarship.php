<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'provider',
        'description',
        'requirements',
        'amount',
        'deadline',
        'type',
        'level',
        'link',
        'is_active'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the deadline in human readable format
     */
    public function getDaysLeftAttribute()
    {
        return now()->diffInDays($this->deadline, false);
    }

    /**
     * Scope a query to only include active scholarships
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('deadline', '>', now());
    }

    /**
     * Scope a query to filter by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by level
     */
    public function scopeOfLevel($query, $level)
    {
        return $query->where('level', $level);
    }
}