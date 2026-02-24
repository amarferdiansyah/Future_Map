<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerPathCourse extends Model
{
    protected $fillable = [
        'career_path_id',
        'course_name',
        'course_code',
        'university',
        'platform',
        'link',
        'is_recommended'
    ];

    protected $casts = [
        'is_recommended' => 'boolean',
    ];

    public function careerPath()
    {
        return $this->belongsTo(CareerPath::class);
    }
}