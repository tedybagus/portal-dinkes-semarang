<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $table = 'article_comments';
    
    protected $fillable = [
        'article_id',
        'name',
        'comment',
        'rating',
        'status',
        'ip_address',
        'user_agent',
        'approved_at',
        'approved_by',
        'rejection_reason'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke artikel
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * Relasi ke user yang approve
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope untuk komentar yang sudah approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk komentar pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk komentar rejected
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check apakah komentar sudah approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check apakah komentar masih pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check apakah komentar ditolak
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}