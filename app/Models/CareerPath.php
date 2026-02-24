<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CareerPath extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'industry',
        'avg_salary_min',
        'avg_salary_max',
        'required_skills',
        'recommended_certifications',
        'career_progression',
        'icon'
    ];

    protected $casts = [
        'required_skills' => 'array',
        'recommended_certifications' => 'array',
        'avg_salary_min' => 'decimal:2',
        'avg_salary_max' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($careerPath) {
            $careerPath->slug = Str::slug($careerPath->title);
        });

        static::updating(function ($careerPath) {
            $careerPath->slug = Str::slug($careerPath->title);
        });
    }

    public function courses()
    {
        return $this->hasMany(CareerPathCourse::class);
    }
}