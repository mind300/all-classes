<?php

namespace App\Models;

class Branch extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address',
        'city',
        'street',
        'building_number',
        'floor_number',
        'manager_id',
        'owner_id',
    ];

    // ====================== Relations For Suppliers =================== //
    // Each branch has many cashires
    public function cashires()
    {
        return $this->hasMany(Cashier::class, 'branch_id');
    }

    // Each branch has one manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
