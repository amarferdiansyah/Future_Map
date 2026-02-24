<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'job' => new JobResource($this->whenLoaded('job')),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'avatar' => $this->user->avatar ? asset('uploads/avatars/' . $this->user->avatar) : null,
            ],
            'cv' => [
                'path' => $this->cv_path,
                'url' => asset('uploads/cvs/' . $this->cv_path),
            ],
            'cover_letter' => $this->cover_letter,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel($this->status),
            'status_color' => $this->getStatusColor($this->status),
            'match_score' => $this->match_score,
            'notes' => $this->notes,
            'applied_at' => [
                'datetime' => $this->applied_at->format('Y-m-d H:i:s'),
                'formatted' => $this->applied_at->format('d F Y H:i'),
                'diff' => $this->applied_at->diffForHumans(),
            ],
            'reviewed_at' => $this->reviewed_at ? [
                'datetime' => $this->reviewed_at->format('Y-m-d H:i:s'),
                'formatted' => $this->reviewed_at->format('d F Y H:i'),
            ] : null,
            'links' => [
                'self' => route('api.applications.show', $this->id),
                'download_cv' => route('api.applications.download', $this->id),
            ],
        ];
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Menunggu',
            'reviewed' => 'Direview',
            'interview' => 'Interview',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        ];
        
        return $labels[$status] ?? ucfirst($status);
    }

    private function getStatusColor($status)
    {
        $colors = [
            'pending' => 'yellow',
            'reviewed' => 'blue',
            'interview' => 'purple',
            'accepted' => 'green',
            'rejected' => 'red',
        ];
        
        return $colors[$status] ?? 'gray';
    }
}