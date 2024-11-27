<?php

namespace App\Models;

class RewardRedeem extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'reward_id',
        'success'
    ];

    // ====================== Relations For Community =================== //
    // Each reply belongs to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }
}
