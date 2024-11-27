<?php

namespace App\Models;

class PointHistory extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'point_system_id',
        'success'
    ];

    // ====================== Relations For Mind =================== //
    public function point_system()
    {
        return $this->setConnection('mind')->belongsTo(PointSystem::class, 'point_system_id');
    }

    // ====================== Relations For Community =================== //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
