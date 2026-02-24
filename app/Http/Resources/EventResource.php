<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        $registrationsCount = $this->registrations()->count();
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'type' => $this->type,
            'banner' => $this->banner ? asset('storage/' . $this->banner) : null,
            'schedule' => [
                'start' => [
                    'date' => $this->start_date->format('Y-m-d'),
                    'time' => $this->start_date->format('H:i'),
                    'formatted' => $this->start_date->format('l, d F Y H:i'),
                ],
                'end' => [
                    'date' => $this->end_date->format('Y-m-d'),
                    'time' => $this->end_date->format('H:i'),
                    'formatted' => $this->end_date->format('l, d F Y H:i'),
                ],
            ],
            'location' => [
                'type' => $this->online_url ? 'online' : 'offline',
                'address' => $this->location,
                'online_url' => $this->online_url,
            ],
            'capacity' => [
                'max' => $this->max_participants,
                'registered' => $registrationsCount,
                'remaining' => $this->max_participants ? $this->max_participants - $registrationsCount : null,
                'is_full' => $this->max_participants ? $registrationsCount >= $this->max_participants : false,
            ],
            'pricing' => [
                'is_paid' => $this->is_paid,
                'price' => $this->price,
                'formatted_price' => $this->is_paid ? 'Rp ' . number_format($this->price, 0, ',', '.') : 'Free',
            ],
            'speakers' => $this->speakers ?? [],
            'is_featured' => $this->is_featured,
            'qrcode_token' => $this->when($request->user() && $request->user()->hasRole('admin'), $this->qrcode_token),
            'stats' => [
                'views' => $this->views_count ?? 0,
                'registrations' => $registrationsCount,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                'self' => route('api.events.show', $this->id),
                'register' => route('api.events.register', $this->id),
            ],
        ];
    }
}