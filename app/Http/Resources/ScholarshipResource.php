<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScholarshipResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'provider' => $this->provider,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'amount' => [
                'value' => $this->amount,
                'formatted' => $this->amount ? 'Rp ' . number_format($this->amount, 0, ',', '.') : null,
            ],
            'deadline' => [
                'date' => $this->deadline->format('Y-m-d'),
                'formatted' => $this->deadline->format('d F Y'),
                'is_passed' => $this->deadline->isPast(),
                'days_left' => now()->diffInDays($this->deadline, false),
            ],
            'type' => $this->type,
            'level' => $this->level,
            'link' => $this->link,
            'is_active' => $this->is_active && !$this->deadline->isPast(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                'self' => route('api.scholarships.show', $this->id),
                'external' => $this->link,
            ],
        ];
    }
}