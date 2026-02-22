<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpidInformation extends Model
{
   protected $table = 'ppid_informations';
   protected $fillable = [
        'ppid_category_id',
        'title',
        'description',
        'information_number',
        'type',
        'responsible_unit',
        'information_format',
        'year',
        'published_date',
        'validity_period',
        'file_path',
        'file_size',
        'external_link',
        'keywords',
        'notes',
        'is_public',
        'view_count',
        'download_count',
        'permanent_validity'
    ];

    protected $casts = [
        'published_date' => 'date',
        'validity_period' => 'date',
        'is_public' => 'boolean',
        'view_count' => 'integer',
        'download_count' => 'integer',
        'permanent_validity' => 'boolean'
    ];

    /**
     * Relasi ke kategori
     */
    public function category()
    {
        return $this->belongsTo(PpidCategory::class, 'ppid_category_id');
    }

    /**
     * Relasi ke download logs
     */
    public function downloadLogs()
    {
        return $this->hasMany(PpidDownloadLog::class);
    }

    /**
     * Scope public
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope by year
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('ppid_category_id', $categoryId);
    }

    /**
     * Scope search
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('information_number', 'like', "%{$term}%")
              ->orWhere('keywords', 'like', "%{$term}%");
        });
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    /**
     * Increment view count
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }
}


