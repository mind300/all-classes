<?php

namespace App\Models;

class TermCondation extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'details'
    ];
}
