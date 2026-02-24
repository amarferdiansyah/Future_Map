<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'category'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skills')
                    ->withPivot('proficiency_level')
                    ->withTimestamps();
    }

    public function jobs()
    {
        return $this->belongsToMany(JobListing::class, 'job_skills', 'skill_id', 'job_listing_id')
                    ->withPivot('importance_level')
                    ->withTimestamps();
    }
}