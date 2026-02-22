<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintFlow extends Model
{
  protected $fillable = [
        'step_number',
        'title',
        'description',
        'icon',
        'duration_days',
        'order',
        'is_active',
    ];

    protected $casts = [
        'step_number' => 'integer',
        'duration_days' => 'integer',
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Scope: Active flows
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Ordered
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
