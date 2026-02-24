<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => \Str::slug($this->title),
            'description' => $this->description,
            'requirements' => $this->requirements,
            'benefits' => $this->benefits,
            'type' => $this->type,
            'work_style' => $this->work_style,
            'location' => $this->location,
            'salary' => [
                'min' => $this->salary_min,
                'max' => $this->salary_max,
                'formatted_min' => $this->salary_min ? 'Rp ' . number_format($this->salary_min, 0, ',', '.') : null,
                'formatted_max' => $this->salary_max ? 'Rp ' . number_format($this->salary_max, 0, ',', '.') : null,
                'range' => $this->salary_min && $this->salary_max ? 
                    'Rp ' . number_format($this->salary_min, 0, ',', '.') . ' - Rp ' . number_format($this->salary_max, 0, ',', '.') : 
                    'Negotiable'
            ],
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'email' => $this->company->email,
                'logo' => $this->company->avatar ? asset('uploads/avatars/' . $this->company->avatar) : null,
            ],
            'major' => $this->major ? [
                'id' => $this->major->id,
                'name' => $this->major->name,
                'code' => $this->major->code,
                'degree_level' => $this->major->degree_level,
            ] : null,
            'skills' => SkillResource::collection($this->skills),
            'requirements_summary' => [
                'min_gpa' => $this->min_gpa,
                'min_semester' => $this->min_semester,
                'major' => $this->major?->name ?? 'All Majors',
            ],
            'stats' => [
                'views' => $this->views_count,
                'applications' => $this->applications_count,
                'slots' => $this->slots,
                'remaining_slots' => $this->slots - $this->applications_count,
            ],
            'deadline' => [
                'date' => $this->deadline->format('Y-m-d'),
                'formatted' => $this->deadline->format('d F Y'),
                'is_passed' => $this->deadline->isPast(),
                'days_left' => now()->diffInDays($this->deadline, false),
            ],
            'is_active' => $this->is_active && !$this->deadline->isPast(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                'self' => route('api.jobs.show', $this->id),
                'apply' => route('api.jobs.apply', $this->id),
            ],
        ];
    }
}