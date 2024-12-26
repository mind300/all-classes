<?php

namespace App\Models;

class Comment extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment',
        'user_id',
        'model_id',
        'model_type'
    ];

    // ====================== Relations For Community =================== //
    // Each comment belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each comment has many likes
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    // Each news has many replies
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
