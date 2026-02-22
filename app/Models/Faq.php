<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
   protected $table = 'faqs';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'kategori',
        'urutan',
        'is_active',
        'view_count',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'urutan'      => 'integer',
        'view_count'  => 'integer',
    ];

    protected $attributes = [
        'kategori'   => 'Umum',
        'urutan'     => 0,
        'is_active'  => true,
        'view_count' => 0,
    ];

    /* ─── Scopes ─────────────────────────────────────── */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc')->orderBy('created_at', 'asc');
    }

    /* ─── Helpers ────────────────────────────────────── */

    public function incrementView()
    {
        $this->increment('view_count');
    }

    public static function getKategoris(): array
    {
        return self::active()
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->toArray();
    }
}
