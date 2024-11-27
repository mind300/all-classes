<?php

namespace App\Models;

class EventHistory extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'user_id',
        'going',
    ];

    // ====================== Relations =================== //
    // Each user belongs to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Each history belongs to event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
