<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniBridgeQuestion extends Model
{
    protected $fillable = [
        'user_id', 'alumni_id', 'question', 'answer', 
        'is_anonymous', 'status', 'answered_at'
    ];

    protected $casts = [
        'answered_at' => 'datetime',
        'is_anonymous' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alumni()
    {
        return $this->belongsTo(User::class, 'alumni_id');
    }
}