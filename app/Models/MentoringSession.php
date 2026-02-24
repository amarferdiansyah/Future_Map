<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentoringSession extends Model
{
    protected $fillable = [
        'mentor_id', 'mentee_id', 'scheduled_at', 'duration', 'type',
        'location', 'meeting_link', 'topic', 'notes', 'status'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }
}