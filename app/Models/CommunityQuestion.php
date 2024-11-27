<?php

namespace App\Models;

class CommunityQuestion extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'question',
        'active',
        'required',
    ];
}
