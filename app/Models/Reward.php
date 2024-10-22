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
        'name',
        'discount',
        'quantity',
        'redeem_points',
        'description',
        'status',
    ];

    // ====================== Relations =================== //
}
