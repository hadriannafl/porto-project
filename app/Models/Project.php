<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'desc', 'image', 'tags', 'year', 'category', 'bg', 'demo_url', 'github_url', 'order',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
