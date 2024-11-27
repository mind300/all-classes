<?php

namespace App\Models;

class InviteFriend extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'mobile_number',
        'user_id',
    ];

    // ====================== Relations For Community =================== //
    // Each invite friend belongs to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
