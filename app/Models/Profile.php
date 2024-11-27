<?php

namespace App\Models;

class Profile extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile_number',
        'job_id',
    ];

    // ====================== Relations For Suppliers =================== //
    // Each profile belong to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
