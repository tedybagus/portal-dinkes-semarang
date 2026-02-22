<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produkhukum extends Model
{
    protected $table = 'produk_hukum';

    // Kategori constants
    const KATEGORI = [
        'perda'     => 'Peraturan Daerah',
        'perbup'    => 'Peraturan Bupati',
        'sk'        => 'Surat Keputusan',
        'se'        => 'Surat Edaran',
        'pergub'    => 'Peraturan Gubernur',
        'instruksi' => 'Instruksi',
        'lainnya'   => 'Lainnya',
    ];

    protected $fillable = [
        'nomor',
        'tahun',
        'kategori',
        'tentang',
        'tanggal_penetapan',
        'tanggal_berlaku',
        'status',
        'file_path',
        'file_name',
        'file_size',
        'keterangan',
        'download_count',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'tanggal_penetapan' => 'date',
        'tanggal_berlaku'   => 'date',
        'is_active'         => 'boolean',
        'download_count'    => 'integer',
        'file_size'         => 'integer',
        'tahun'             => 'integer',
    ];

    protected $appends = ['nomor_lengkap', 'file_size_readable'];

    /* ─── Relationships ─────────────────────────────── */
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /* ─── Scopes ────────────────────────────────────── */
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBerlaku($query)
    {
        return $query->where('status', 'berlaku');
    }

    public function scopeByKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeByTahun($query, int $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('tahun', 'desc')
            ->orderBy('tanggal_penetapan', 'desc');
    }

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) return $query;

        return $query->where(function($q) use ($search) {
            $q->where('nomor', 'like', "%{$search}%")
              ->orWhere('tentang', 'like', "%{$search}%")
              ->orWhere('tahun', 'like', "%{$search}%");
        });
    }

    /* ─── Accessors ─────────────────────────────────── */
    
    public function getNomorLengkapAttribute(): string
    {
        return "{$this->kategori_label} Nomor {$this->nomor} Tahun {$this->tahun}";
    }

    public function getKategoriLabelAttribute(): string
    {
        return self::KATEGORI[$this->kategori] ?? $this->kategori;
    }

    public function getFileSizeReadableAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 2) . ' KB';
        if ($bytes < 1073741824) return round($bytes / 1048576, 2) . ' MB';
        return round($bytes / 1073741824, 2) . ' GB';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'berlaku' => '<span class="badge badge-success">Berlaku</span>',
            'tidak_berlaku' => '<span class="badge badge-danger">Tidak Berlaku</span>',
            'draft' => '<span class="badge badge-warning">Draft</span>',
            default => '<span class="badge badge-secondary">Unknown</span>',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'berlaku' => '#10b981',
            'tidak_berlaku' => '#ef4444',
            'draft' => '#f59e0b',
            default => '#94a3b8',
        };
    }

    /* ─── Methods ───────────────────────────────────── */
    
    public function incrementDownload(): void
    {
        $this->increment('download_count');
    }

    public static function getAvailableYears(): array
    {
        return static::selectRaw('DISTINCT tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
    }

    public static function getKategoriWithCount()
    {
        return static::selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->kategori => $item->count];
            })
            ->toArray();
    }
}
