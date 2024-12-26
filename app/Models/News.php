<?php

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Casts\Attribute;

class News extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'caption',
        'user_id',
        'likes_count',
        'comment_count'
    ];

    // ====================== Relations For Community =================== //
    public function likes()
    {
        return $this->morphMany(Like::class, 'model');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'model');
    }

    // ====================== Media =================== //
    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('news')->singleFile();
    }
}
