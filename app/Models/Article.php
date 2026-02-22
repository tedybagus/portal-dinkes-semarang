<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category_id',
        'author_id',
        'department_id',
        'reviewer_id',
        'status',
        'rejection_reason',
        'reviewed_at',
        'published_at',
        'article_date',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
            'published_at' => 'datetime',
            'article_date' => 'date',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
     // Scope khusus publik
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
    /**
 * Relasi ke komentar
 */
public function comments()
{
    return $this->hasMany(ArticleComment::class, 'article_id');
}

/**
 * Relasi ke komentar yang approved
 */
public function approvedComments()
{
    return $this->hasMany(ArticleComment::class, 'article_id')
                ->where('status', 'approved');
}

}
