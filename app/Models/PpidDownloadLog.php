<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpidDownloadLog extends Model
{
    protected $table = 'ppid_download_logs';
     protected $fillable = [
        'ppid_information_id',
        'ip_address',
        'user_agent',
        'downloaded_at'
    ];

    protected $casts = [
        'downloaded_at' => 'datetime'
    ];

    /**
     * Relasi ke informasi
     */
    public function information()
    {
        return $this->belongsTo(PpidInformation::class, 'ppid_information_id');
    }

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($log) {
            if (empty($log->downloaded_at)) {
                $log->downloaded_at = now();
            }
        });
    }
}