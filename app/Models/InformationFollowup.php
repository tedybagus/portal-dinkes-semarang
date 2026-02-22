<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformationFollowup extends Model
{
     protected $fillable = [
        'question',
        'answer',
        'order',
        'is_active',
        'information_request_id',
        'status',
        'description',
        'updated_by'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
    public function request()
    {
        return $this->belongsTo(InformationRequest::class);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
