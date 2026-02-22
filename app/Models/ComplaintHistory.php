<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintHistory extends Model
{
    protected $fillable = [
        'complaint_id',
        'status',
        'description',
        'updated_by',
    ];

    protected $casts = [
        'complaint_id' => 'integer',
    ];

    /**
     * Relationship to complaint
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    /**
     * Get status label
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
}
