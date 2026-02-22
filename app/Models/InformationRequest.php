<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class InformationRequest extends Model
{
 protected $fillable = [
        'registration_number',
        'name',
        'address',
        'phone',
        'email',
        'id_card_number',
        'id_card_file',
        'requester_type',
        'information_needed',
        'information_purpose',
        'information_format',
        'delivery_method',
        'status',
        'rejection_reason',
        'admin_notes',
        'result_file',
        'submitted_at',
        'processed_at',
        'completed_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    /**
     * Relasi ke followups
     */
    public function followups()
    {
        return $this->hasMany(InformationFollowup::class);
    }

    /**
     * Scope untuk filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('registration_number', 'like', "%{$term}%")
              ->orWhere('name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%");
        });
    }

    /**
     * Generate nomor registrasi
     */
    public static function generateRegistrationNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        // Format: REG/YYYY/MM/XXXX
        $lastRequest = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->first();
        
        $sequence = $lastRequest ? intval(substr($lastRequest->registration_number, -4)) + 1 : 1;
        
        return sprintf('REG-%s-%s-%04d', $year, $month, $sequence);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'submitted' => 'badge-warning',
            'verified' => 'badge-info',
            'processed' => 'badge-primary',
            'ready' => 'badge-success',
            'completed' => 'badge-success',
            'rejected' => 'badge-danger'
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'submitted' => 'Diajukan',
            'verified' => 'Diverifikasi',
            'processed' => 'Sedang Diproses',
            'ready' => 'Siap Diambil',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get requester type label
     */
    public function getRequesterTypeLabelAttribute()
    {
        $labels = [
            'perorangan' => 'Perorangan',
            'kelompok' => 'Kelompok Orang',
            'organisasi' => 'Organisasi'
        ];

        return $labels[$this->requester_type] ?? $this->requester_type;
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->registration_number)) {
                $model->registration_number = self::generateRegistrationNumber();
            }
            if (empty($model->submitted_at)) {
                $model->submitted_at = Carbon::now();
            }
        });
    }
}

