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
    public function history()
    {
        return $this->hasMany(EventHistory::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
