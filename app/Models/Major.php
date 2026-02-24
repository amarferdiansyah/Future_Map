<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = [
        'department_id', 'name', 'code', 'degree_level', 'description'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }
}