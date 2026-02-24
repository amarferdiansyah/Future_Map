<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerPathResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'industry' => $this->industry,
            'salary_range' => [
                'min' => $this->avg_salary_min,
                'max' => $this->avg_salary_max,
                'formatted_min' => $this->avg_salary_min ? 'Rp ' . number_format($this->avg_salary_min, 0, ',', '.') : null,
                'formatted_max' => $this->avg_salary_max ? 'Rp ' . number_format($this->avg_salary_max, 0, ',', '.') : null,
                'range' => $this->avg_salary_min && $this->avg_salary_max ? 
                    'Rp ' . number_format($this->avg_salary_min, 0, ',', '.') . ' - Rp ' . number_format($this->avg_salary_max, 0, ',', '.') : 
                    'Information not available',
            ],
            'required_skills' => $this->required_skills ?? [],
            'recommended_certifications' => $this->recommended_certifications ?? [],
            'career_progression' => $this->career_progression,
            'career_levels' => $this->parseCareerLevels($this->career_progression),
            'icon' => $this->icon ? asset('storage/' . $this->icon) : null,
            'courses' => CareerPathCourseResource::collection($this->whenLoaded('courses')),
            'courses_count' => $this->courses_count ?? $this->courses()->count(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                'self' => route('api.career-paths.show', $this->slug),
                'jobs' => route('api.jobs.index') . '?career=' . urlencode($this->title),
            ],
        ];
    }

    private function parseCareerLevels($progression)
    {
        if (!$progression) return [];
        
        $levels = explode('→', $progression);
        $result = [];
        
        foreach ($levels as $index => $level) {
            $result[] = [
                'level' => $index + 1,
                'title' => trim($level),
                'description' => $this->getLevelDescription($index),
            ];
        }
        
        return $result;
    }

    private function getLevelDescription($index)
    {
        $descriptions = [
            'Entry Level / Fresh Graduate',
            'Junior / Mid Level',
            'Senior Level',
            'Lead / Manager',
            'Director / Executive',
        ];
        
        return $descriptions[$index] ?? 'Professional Level';
    }
}