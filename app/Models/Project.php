<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'desc', 'tags', 'year', 'category', 'bg', 'demo_url', 'github_url', 'order',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    protected $appends = ['image', 'image_urls'];

    public function projectImages()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function getImageAttribute(): array
    {
        return $this->projectImages->pluck('path')->values()->toArray();
    }

    public function getImageUrlsAttribute(): array
    {
        return $this->projectImages->pluck('path')
            ->map(fn($p) => asset('storage/' . $p))
            ->values()
            ->toArray();
    }
}
