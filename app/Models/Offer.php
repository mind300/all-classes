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

    // ====================== Relations For Mind =================== //
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // ====================== Media =================== //
    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('offer')->singleFile();
    }
}
