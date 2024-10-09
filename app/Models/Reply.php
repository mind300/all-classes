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

    // ====================== Relations =================== //
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
