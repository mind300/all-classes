<?php

namespace App\Models;

class Job extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'remote',
        'location',
        'salary_range',
        'user_experience',
        'description',
        'user_id',
    ];

    // ====================== Relations =================== //
}
