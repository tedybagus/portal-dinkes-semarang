<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewService extends Model
{
     protected $table = 'review_services';

    protected $fillable = [
        'review_id',
        'service_type',
    ];

    protected $casts = [
        'review_id' => 'integer',
    ];

    /* ─── Relationships ─────────────────────────────── */
    
    /**
     * Belongs to Review
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    /* ─── Accessors ─────────────────────────────────── */
    
    /**
     * Get service type label
     */
    public function getServiceLabelAttribute(): string
    {
        return Review::LAYANAN_TYPES[$this->service_type] ?? $this->service_type;
    }

    /* ─── Scopes ────────────────────────────────────── */
    
    /**
     * Filter by service type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('service_type', $type);
    }

    /* ─── Static Methods ────────────────────────────── */
    
    /**
     * Get popular services (most used in reviews)
     */
    public static function getPopularServices(int $limit = 5): array
    {
        return static::selectRaw('service_type, COUNT(*) as count')
            ->groupBy('service_type')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type'  => $item->service_type,
                    'label' => Review::LAYANAN_TYPES[$item->service_type] ?? $item->service_type,
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }
}
