<?php

namespace App\Models;

class PointSystem extends BaseModel
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
}
