<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Klinik extends Model
{
     use HasFactory;
      protected $table = 'kliniks';
    protected $fillable = [
        'nama',
        'kode',
        'icon',
        'color',
        'deskripsi',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }
    public function fasyankes()
    {
        return $this->hasMany(Fasyankes::class, 'klinik_id');
    }

    public function getMapUrlAttribute()
    {
    if ($this->latitude && $this->longitude) {
        // OpenStreetMap URL
        return "https://www.openstreetmap.org/?mlat={$this->latitude}&mlon={$this->longitude}#map=15/{$this->latitude}/{$this->longitude}";
    }
    return null;
    }
}