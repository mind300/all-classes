<?php

namespace App\Models;

class Room extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'members_count',
        'user_id',
    ];

    // ====================== Relations For Community =================== //
    // Each room offer belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each room hasmany posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
