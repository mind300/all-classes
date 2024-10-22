<?php

namespace App\Models;

class Offer extends BaseModel
{
    /**
     * Use the 'mind' database
     */
    protected $connection = 'mind';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category',
        'brand_info',
        'title',
        'discount',
        'description',
        'qr_code',
        'brand_id',
    ];

    // ====================== Relations =================== //
    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
