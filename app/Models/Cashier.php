<?php

namespace App\Models;

class Cashier extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'branch_id',
    ];

    // ====================== Relations For Suppliers =================== //
    // Each cashier belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each cashier belongs to branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
