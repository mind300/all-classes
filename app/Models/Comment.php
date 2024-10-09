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
        'news_id',
        'user_id',
    ];

    // ====================== Relations =================== //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
    
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
