<?php

namespace App\Models;

class Charity extends BaseModel
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
        'name',
        'phone',
        'address',
        'website',
        'email',
        'description',
    ];

    // ====================== Relations For Mind =================== //
    // Mind has many charities
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
