<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformationFlow extends Model
{
     protected $fillable = [
        'title',
        'description',
        'step_number',
        'icon',
        'duration_days',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('step_number', 'asc');
    }
}
