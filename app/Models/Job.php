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
        'title',
        'type',
        'remote',
        'location',
        'salary_range',
        'user_experience',
        'description',
        'how_to_apply',
        'user_id',
    ];

    // ====================== Relations =================== //\
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
