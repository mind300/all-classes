<?php

namespace App\Models;

class Reply extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reply',
        'comment_id',
        'user_id',
    ];

    // ====================== Relations For Community =================== //
    // Each reply belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each reply has many likes
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
