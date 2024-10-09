<?php

namespace App\Models;

class Event extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'date',
        'time',
        'place',
        'description',
        'user_id'
    ];

    // ====================== Relations =================== //
}
