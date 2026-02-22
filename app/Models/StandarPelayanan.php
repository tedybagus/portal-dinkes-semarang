<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StandarPelayanan extends Model
{
    protected $table = 'standar_pelayanans';

    protected $fillable = [
        'nama', 'slug', 'kategori', 'deskripsi',
        'persyaratan', 'catatan', 'icon', 'warna',
        'urutan', 'is_active', 'view_count',
    ];

    protected $casts = [
        'persyaratan' => 'array',
        'is_active'   => 'boolean',
        'urutan'      => 'integer',
        'view_count'  => 'integer',
    ];

    protected $attributes = [
        'is_active'  => true,
        'view_count' => 0,
        'urutan'     => 0,
    ];

    /* ─── Boot ──────────────────────────────── */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }

    /* ─── Scopes ────────────────────────────── */
    public function scopeActive($q)   { return $q->where('is_active', true); }
    public function scopeOrdered($q)  { return $q->orderBy('urutan')->orderBy('nama'); }

    /* ─── Helpers ───────────────────────────── */
    public function incrementView()   { $this->increment('view_count'); }

    public static function getKategoris(): array
    {
        return self::distinct()->orderBy('kategori')->pluck('kategori')->toArray();
    }

    // Total semua item persyaratan
    public function getTotalPersyaratanAttribute(): int
    {
        return collect($this->persyaratan)
            ->sum(fn($s) => count($s['items'] ?? []));
    }
}