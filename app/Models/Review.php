<?php

namespace App\Models;

use App\Models\ReviewService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Review extends Model
{protected $table = 'reviews';

    // ════════════════════════════════════════════════════════
    // SERVICE TYPES CONSTANT
    // ════════════════════════════════════════════════════════
    const LAYANAN_TYPES = [
        'layanan_umum'              => 'Layanan Umum',
        'layanan_kesehatan'         => 'Layanan Kesehatan',
        'administrasi_kependudukan' => 'Administrasi Kependudukan',
        'perizinan'                 => 'Perizinan',
        'pengaduan'                 => 'Pengaduan Masyarakat',
        'informasi'                 => 'Layanan Informasi',
        'fasyankes'                 => 'Fasilitas Kesehatan',
        'ppid'                      => 'PPID',
        'lainnya'                   => 'Lainnya',
    ];

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'foto',
        'rating',
        'review_text',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'ip_address',
        'tracking_code',
        'view_count',
    ];

    protected $casts = [
        'rating'      => 'integer',
        'view_count'  => 'integer',
        'approved_at' => 'datetime',
    ];

    protected $attributes = [
        'status'     => 'pending',
        'view_count' => 0,
    ];

    /* ─── Boot ──────────────────────────────────────── */
    
    protected static function boot()
    {
        parent::boot();

        // Auto-generate tracking code on create
        static::creating(function ($review) {
            if (empty($review->tracking_code)) {
                $review->tracking_code = static::generateTrackingCode();
            }
        });
    }

    /* ─── Relationships ─────────────────────────────── */
    
    /**
     * Review has many services
     */
    public function reviewServices()
    {
        return $this->hasMany(ReviewService::class);
    }

    /**
     * Review approved by user
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* ─── Scopes ────────────────────────────────────── */
    
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeByService($query, string $serviceType)
    {
        return $query->whereHas('reviewServices', function ($q) use ($serviceType) {
            $q->where('service_type', $serviceType);
        });
    }
     public function scopeRecent($query, int $limit = 10)
    {
        return $query->latest()->limit($limit);
    }

    /* ─── Methods ───────────────────────────────────── */
    
    /**
     * Approve review
     */
    public function approve($userId = null): void
    {
        $this->update([
            'status'      => 'approved',
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);
    }

    /**
     * Reject review
     */
    public function reject(string $reason = null): void
    {
        $this->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }

    /**
     * Unapprove (batalkan approval)
     */
    public function unapprove(): void
    {
        $this->update([
            'status'      => 'pending',
            'approved_by' => null,
            'approved_at' => null,
        ]);
    }

    /**
     * Increment view count
     */
    public function incrementView(): void
    {
        $this->increment('view_count');
    }

    /**
     * Generate unique tracking code
     */
    public static function generateTrackingCode(): string
    {
        do {
            $code = 'REV-' . strtoupper(Str::random(8));
        } while (static::where('tracking_code', $code)->exists());

        return $code;
    }

    /**
     * Find by tracking code
     */
    public static function findByTrackingCode(string $code): ?self
    {
        return static::where('tracking_code', $code)->first();
    }

    /* ─── Accessors ─────────────────────────────────── */
    
    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'approved' => '#10b981',
            'pending'  => '#f59e0b',
            'rejected' => '#ef4444',
            default    => '#94a3b8',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'Disetujui',
            'pending'  => 'Menunggu',
            'rejected' => 'Ditolak',
            default    => 'Unknown',
        };
    }

    /**
     * Get rating stars HTML
     */
    public function getRatingStarsAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $class = $i <= $this->rating ? 'fas fa-star' : 'far fa-star';
            $stars .= "<i class='$class'></i>";
        }
        return $stars;
    }

    /* ─── Static Helpers ────────────────────────────── */
    
    /**
     * Get average rating
     */
    public static function getAverageRating(): float
    {
        return static::approved()->avg('rating') ?: 0;
    }

    /**
     * Get rating distribution
     */
    public static function getRatingDistribution(): array
    {
        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $distribution[$i] = static::approved()->where('rating', $i)->count();
        }
        return $distribution;
    }

    /**
     * Get total approved reviews
     */
    public static function getTotalApproved(): int
    {
        return static::approved()->count();
    }
}