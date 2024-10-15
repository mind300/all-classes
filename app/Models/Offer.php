<?php

namespace App\Models;

class Offer extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category',
        'brand_info',
        'title',
        'price_before',
        'price_after',
        'description',
        'brand_id',
    ];

    // ====================== Relations =================== //
}
