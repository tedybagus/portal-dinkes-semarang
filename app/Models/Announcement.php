<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'image',
        'start_date',
        'end_date',
        'is_active',
        'is_pinned',
        'view_count',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'is_active'  => 'boolean',
        'is_pinned'  => 'boolean',
        'view_count' => 'integer',
        'file_size'  => 'integer',
    ];

    protected $appends = ['excerpt', 'file_icon', 'file_size_readable'];

    /* ─── Relationships ─────────────────────────────── */
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /* ─── Scopes ────────────────────────────────────── */
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('is_pinned', 'desc')
            ->orderBy('start_date', 'desc')
            ->orderBy('created_at', 'desc');
    }

    /* ─── Accessors ─────────────────────────────────── */
    
    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->content), 150);
    }

    public function getFileIconAttribute(): ?string
    {
        if (!$this->file_type) return null;

        return match($this->file_type) {
            'pdf'  => 'fa-file-pdf',
            'doc', 'docx' => 'fa-file-word',
            'xls', 'xlsx' => 'fa-file-excel',
            'ppt', 'pptx' => 'fa-file-powerpoint',
            'zip', 'rar'  => 'fa-file-archive',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'fa-file-image',
            default => 'fa-file-alt',
        };
    }

    public function getFileSizeReadableAttribute(): ?string
    {
        if (!$this->file_size) return null;

        $bytes = $this->file_size;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 2) . ' KB';
        if ($bytes < 1073741824) return round($bytes / 1048576, 2) . ' MB';
        return round($bytes / 1073741824, 2) . ' GB';
    }

    /* ─── Methods ───────────────────────────────────── */
    
    public function incrementView(): void
    {
        $this->increment('view_count');
    }

    public function hasFile(): bool
    {
        return !empty($this->file_path);
    }

    public function hasImage(): bool
    {
        return !empty($this->image);
    }

    public function isActive(): bool
    {
        if (!$this->is_active) return false;
        
        $now = now();
        
        if ($this->start_date && $now->lt($this->start_date)) return false;
        if ($this->end_date && $now->gt($this->end_date)) return false;
        
        return true;
    }

    public function getFileUrl(): ?string
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    public function getImageUrl(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}