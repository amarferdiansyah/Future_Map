<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_listing_id', 'user_id', 'cv_path', 'cover_letter', 'status',
        'match_score', 'notes', 'applied_at'
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(JobListing::class, 'job_listing_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}