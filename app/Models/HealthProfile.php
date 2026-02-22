<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthProfile extends Model
{
    protected $fillable = [
        'name',
        'file_path',
        'file_type',
        'view_count',
        'download_count',
    ];
}
