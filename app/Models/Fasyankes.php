<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fasyankes extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fasyankes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'klinik_id',
        'nama',
        'kode',
        'alamat',
        'latitude',
        'longitude',
    ];
 

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];
    public function kategori()
    {
        return $this->belongsTo(Klinik::class, 'klinik_id');
    }
    public function klinik()
    {
        return $this->belongsTo(Klinik::class);
    }
    /**
     * Daftar kategori fasyankes yang tersedia
     *
     * @return array
     */
    // public static function getKategoriOptions(): array
    // {
    //     return [
    //         'klinik' => 'Klinik',
    //         'puskesmas' => 'Puskesmas',
    //         'tpmd_dg' => 'TPMD & DG',
    //         'tpmb' => 'TPMB',
    //         'tpmp' => 'TPMP',
    //         'rumah sakit' => 'Rumah Sakit',
    //         'labkes' => 'Labkes',
    //         'stpt' => 'STPT'
    //     ];
    // }
    

    /**
     * Scope untuk filter berdasarkan kategori
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $kategori
     * @return \Illuminate\Database\Eloquent\Builder
     */
    // public function scopeKategori($query, $kategori)
    // {
    //     return $query->where('kategori', $kategori);
    // }

    /**
     * Scope untuk filter yang memiliki koordinat
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasCoordinates($query)
    {
        return $query->whereNotNull('latitude')
                     ->whereNotNull('longitude');
    }

    /**
     * Scope untuk pencarian
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama', 'like', '%' . $search . '%')
              ->orWhere('kode_fasyankes', 'like', '%' . $search . '%')
              ->orWhere('alamat', 'like', '%' . $search . '%');
        });
    }

    /**
     * Accessor untuk mendapatkan label kategori
     *
     * @return string
     */
    // public function getKategoriLabelAttribute(): string
    // {
    //     return self::getKategoriOptions()[$this->kategori] ?? $this->kategori;
    // }
// Accessor untuk ambil nama kategori
        public function getKategoriAttribute()
        {
            return $this->klinik ? $this->klinik->nama : '-';
        }
    /**
     * Accessor untuk mendapatkan URL Google Maps
     *
     * @return string|null
     */
    public function getGoogleMapsUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }

    /**
     * Accessor untuk cek apakah memiliki koordinat
     *
     * @return bool
     */
    public function getHasCoordinatesAttribute(): bool
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    /**
     * Accessor untuk mendapatkan koordinat dalam format string
     *
     * @return string|null
     */
    public function getCoordinatesStringAttribute(): ?string
    {
        if ($this->has_coordinates) {
            return "{$this->latitude}, {$this->longitude}";
        }
        return null;
    }
}
