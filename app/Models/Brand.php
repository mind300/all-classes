<?php

namespace App\Models;

class Brand extends BaseModel
{
    protected $connection = 'mind';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    // ====================== Relations For Mind =================== //
    // Each brand has many offers
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    // ====================== Relations For Suppliers =================== //
    // Each brand has many suppliers
    public function suppliers()
    {
        return $this->setConnection('suppliers')->hasMany(User::class, 'brand_id');
    }
    // Each brand has belongs to supplier
    public function supplier()
    {
        return $this->setConnection('suppliers')->hasOne(User::class, 'brand_id');
    }

    // ====================== Media =================== //
    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('brand')->singleFile();
    }
}
