<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'route_name',
        'role_slug',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeForRole($query, $roleSlug)
    {
        return $query->where('role_slug', $roleSlug);
    }

    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    public function isActive(): bool
    {
        if (!$this->route_name) {
            return false;
        }
        return request()->routeIs($this->route_name . '*');
    }
}
