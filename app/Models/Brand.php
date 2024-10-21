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

    // ====================== Relations =================== //
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
