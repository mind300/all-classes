<?php

namespace App\Models;

class Policy extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description'
    ];

    // ====================== Relations For Community =================== //
}
