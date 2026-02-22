<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PejabatStruktural extends Model
{
    protected $table = 'pejabat_struktural';
    
    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
        'foto',
        'pendidikan',
        'riwayat_jabatan',
        'email',
        'phone',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope untuk data aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope dengan urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
