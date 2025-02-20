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
        'price',
        'description',
        'user_id'
    ];

    // ====================== Relations For Community =================== //
    // Each buy and sell belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ====================== Media =================== //
    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('buy_sell')->singleFile();
    }
}
