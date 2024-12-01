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

    // ====================== Relations For Community =================== //
    // Each event belongs to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Each event has many histories
    public function histories()
    {
        return $this->hasMany(EventHistory::class, 'event_id');
    }

    // ====================== Media =================== //
    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('event')->singleFile();
    }
}
