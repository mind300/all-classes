<?php

namespace App\Models;

class Message extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_id',
        'member_id',
        'message'
    ];

    // ====================== Relations For Community =================== //
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
