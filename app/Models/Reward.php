<?php

namespace App\Models;

class Reward extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category',
        'brand_id',
        'offer_name',
        'redeem_point',
        'description',
    ];
}
