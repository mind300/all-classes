<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'likes_count',
        'comment_count',
        'room_id',
        'user_id',
    ];

    // ====================== Relations For Community =================== //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

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
        $this->addMediaCollection('posts')->singleFile();
    }
}
