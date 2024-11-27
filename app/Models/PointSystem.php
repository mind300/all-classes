<?php

namespace App\Models;

class PointSystem extends BaseModel
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
        'action',
        'display_name',
        'points',
        'active'
    ];

    // ====================== Relations For Community =================== //
}
