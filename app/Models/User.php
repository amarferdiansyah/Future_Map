<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'nim', 'phone', 'avatar', 
        'is_active', 'provider', 'provider_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $guard_name = 'web';

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills')
                    ->withPivot('proficiency_level')
                    ->withTimestamps();
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function jobs()
    {
        return $this->hasMany(JobListing::class, 'company_id');
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isMahasiswa()
    {
        return $this->hasRole('mahasiswa');
    }

    public function isAlumni()
    {
        return $this->hasRole('alumni');
    }

    public function isCompany()
    {
        return $this->hasRole('company');
    }

    public function isDosen()
    {
        return $this->hasRole('dosen');
    }
    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }
        
        // Jika sudah URL lengkap
        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }
        
        // Jika path storage
        return Storage::url($this->avatar);
    }

    /**
     * Get the user's avatar with fallback.
     */
    public function getAvatarWithFallbackAttribute()
    {
        return $this->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&size=128&background=0D8F81&color=fff';
    }
}