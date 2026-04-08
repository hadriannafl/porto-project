<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'desc', 'image', 'tags', 'year', 'category', 'bg', 'demo_url', 'github_url', 'order',
    ];

    protected $casts = [
        'tags'  => 'array',
        'image' => 'array',
    ];

    protected $appends = ['image_urls'];

    public function getImageUrlsAttribute(): array
    {
        $images = $this->image ?? [];
        return array_values(array_map(fn($img) => asset('storage/' . $img), $images));
    }
}
