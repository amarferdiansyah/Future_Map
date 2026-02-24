<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'major_id', 'semester', 'gpa', 'graduation_date',
        'linkedin_url', 'portfolio_url', 'bio', 'cv_path',
        'education_history', 'work_experience', 'certifications'
    ];

    protected $casts = [
        'gpa' => 'decimal:2',
        'education_history' => 'array',
        'work_experience' => 'array',
        'certifications' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}