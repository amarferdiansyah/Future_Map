<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $table = 'job_listings';
    
    protected $fillable = [
        'company_id', 'title', 'description', 'requirements', 'benefits',
        'type', 'work_style', 'location', 'salary_min', 'salary_max',
        'major_id', 'min_gpa', 'min_semester', 'deadline', 'slots',
        'is_active', 'views_count', 'applications_count'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills', 'job_listing_id', 'skill_id')
                    ->withPivot('importance_level')
                    ->withTimestamps();
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_listing_id');
    }
}