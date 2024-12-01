<?php

namespace App\Models;

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
        return $this->hasMany(Comment::class);
    }

    // ====================== Media =================== //
    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('news')->singleFile();
    }
}
