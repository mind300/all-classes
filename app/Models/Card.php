<?php

namespace App\Models;

use App\Casts\EncryptCast;

class Card extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'card_type',
        'card_number',
        'masked_pan',
        'card_token',
        'primary',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'card_token',
        'masked_pan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'card_token' => EncryptCast::class
    ];
}
