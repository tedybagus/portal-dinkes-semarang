<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model
{
    protected $fillable = [
        'complaint_service_id',
        'ticket_number',
        'reporter_name',
        'reporter_nik',
        'reporter_address',
        'reporter_phone',
        'reporter_email',
        'subject',
        'description',
        'location',
        'incident_date',
        'evidence_file',
        'evidence_file_size',
        'priority',
        'status',
        'admin_notes',
        'response',
        'response_file',
        'assigned_to',
        'verified_at',
        'resolved_at',
        'closed_at',
        'satisfaction_rating',
        'feedback',
        'view_count',
        'download_count',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'verified_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'satisfaction_rating' => 'integer',
        'view_count' => 'integer',
        'download_count' => 'integer',
    ];

    /**
     * The attributes default values.
     */
    protected $attributes = [
        'view_count' => 0,
        'download_count' => 0,
        'status' => 'submitted',
        'priority' => 'medium',
    ];

    /**
     * Boot method - Auto generate ticket number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($complaint) {
            if (empty($complaint->ticket_number)) {
                $complaint->ticket_number = self::generateTicketNumber();
            }
            
            // Ensure counters have default values
            if (is_null($complaint->view_count)) {
                $complaint->view_count = 0;
            }
            
            if (is_null($complaint->download_count)) {
                $complaint->download_count = 0;
            }
        });
    }

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber()
    {
        $date = date('Ymd');
        $random = strtoupper(Str::random(4));
        
        $ticketNumber = "ADU-{$date}-{$random}";
        
        // Check if exists, regenerate if duplicate
        while (self::where('ticket_number', $ticketNumber)->exists()) {
            $random = strtoupper(Str::random(4));
            $ticketNumber = "ADU-{$date}-{$random}";
        }
        
        return $ticketNumber;
    }

    /**
     * Relationship to ComplaintService
     */
    public function service()
    {
        return $this->belongsTo(ComplaintService::class, 'complaint_service_id');
    }

    /**
     * Relationship to ComplaintHistory
     */
    public function histories()
    {
        return $this->hasMany(ComplaintHistory::class)->orderBy('created_at', 'desc');
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

    /**
     * Get status label (localized)
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'submitted' => 'Diajukan',
            'verified' => 'Diverifikasi',
            'in_progress' => 'Sedang Diproses',
            'resolved' => 'Diselesaikan',
            'closed' => 'Ditutup',
            'rejected' => 'Ditolak',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get priority label (localized)
     */
    public function getPriorityLabelAttribute()
    {
        $labels = [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'urgent' => 'Mendesak',
        ];

        return $labels[$this->priority] ?? $this->priority;
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'submitted' => '#f59e0b',
            'verified' => '#3b82f6',
            'in_progress' => '#8b5cf6',
            'resolved' => '#10b981',
            'closed' => '#6b7280',
            'rejected' => '#ef4444',
        ];

        return $colors[$this->status] ?? '#6b7280';
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute()
    {
        $colors = [
            'low' => '#10b981',
            'medium' => '#f59e0b',
            'high' => '#ef4444',
            'urgent' => '#7f1d1d',
        ];

        return $colors[$this->priority] ?? '#6b7280';
    }

    /**
     * Scope: Filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Filter by priority
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope: Filter by service
     */
    public function scopeByService($query, $serviceId)
    {
        return $query->where('complaint_service_id', $serviceId);
    }

    /**
     * Scope: Search
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('ticket_number', 'like', "%{$term}%")
              ->orWhere('reporter_name', 'like', "%{$term}%")
              ->orWhere('reporter_phone', 'like', "%{$term}%")
              ->orWhere('subject', 'like', "%{$term}%");
        });
    }

    /**
     * Scope: Recent
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Check if complaint is resolved
     */
    public function isResolved()
    {
        return $this->status === 'resolved';
    }

    /**
     * Check if complaint is closed
     */
    public function isClosed()
    {
        return $this->status === 'closed';
    }

    /**
     * Check if complaint can receive feedback
     */
    public function canReceiveFeedback()
    {
        return $this->status === 'resolved' && !$this->satisfaction_rating;
    }

    /**
     * Get file URL
     */
    public function getEvidenceFileUrlAttribute()
    {
        if ($this->evidence_file) {
            return asset('storage/' . $this->evidence_file);
        }
        return null;
    }

    /**
     * Get response file URL
     */
    public function getResponseFileUrlAttribute()
    {
        if ($this->response_file) {
            return asset('storage/' . $this->response_file);
        }
        return null;
    }
}