<?php

namespace App\Models;

class BuySell extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'place',
        'price_before',
        'price_after',
        'description',
        'user_id'
    ];

    // ====================== Relations =================== //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
