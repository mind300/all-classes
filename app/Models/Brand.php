<?php

namespace App\Models;

class Brand extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    // ====================== Relations Mind =================== //
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    // ====================== Relations Suppliers =================== //
    public function cashires()
    {
        return $this->setConnection('suppliers')->hasMany(User::class, 'brand_id');
    }
}