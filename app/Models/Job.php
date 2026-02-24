<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'job_listings'; // Penting: set tabel yang benar
    
    protected $fillable = [
        'company_id', 'title', 'description', 'requirements', 'benefits',
        'type', 'work_style', 'location', 'salary_min', 'salary_max',
        'major_id', 'min_gpa', 'min_semester', 'deadline', 'slots',
        'is_active', 'views_count', 'applications_count'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'is_active' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'min_gpa' => 'decimal:2',
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

    public function getMatchScoreForUser(User $user)
    {
        $score = 0;
        $totalWeight = 0;

        // Check major match (30%)
        if ($this->major_id && $user->profile && $user->profile->major_id) {
            if ($this->major_id == $user->profile->major_id) {
                $score += 30;
            }
            $totalWeight += 30;
        }

        // Check GPA (20%)
        if ($this->min_gpa && $user->profile && $user->profile->gpa) {
            if ($user->profile->gpa >= $this->min_gpa) {
                $score += 20;
            }
            $totalWeight += 20;
        }

        // Check skills (50%)
        if ($this->skills->count() > 0) {
            $userSkills = $user->skills->pluck('id')->toArray();
            $matchedSkills = 0;
            $totalImportance = 0;
            
            foreach ($this->skills as $skill) {
                $totalImportance += $skill->pivot->importance_level;
                if (in_array($skill->id, $userSkills)) {
                    $matchedSkills += $skill->pivot->importance_level;
                }
            }
            
            if ($totalImportance > 0) {
                $skillScore = ($matchedSkills / $totalImportance) * 50;
                $score += $skillScore;
            }
            $totalWeight += 50;
        }

        // Calculate final percentage
        $finalScore = $totalWeight > 0 ? round(($score / $totalWeight) * 100) : 0;
        
        return $finalScore;
    }
}