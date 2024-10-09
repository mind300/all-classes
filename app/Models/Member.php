<?php

namespace App\Models;

class Member extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'date_of_birth',
        'location',
        'user_id',
    ];

    // ====================== Relations =================== //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
