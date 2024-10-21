<?php

namespace App\Models;

class OfferUse extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'offer_id',
        'user_id',
        'community_name'
    ];

    // ====================== Relations =================== //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}