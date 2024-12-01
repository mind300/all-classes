<?php

namespace App\Models;

class JobAnnouncement extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'type',
        'location',
        'salary_range',
        'user_experience',
        'description',
        'how_to_apply',
        'user_id',
    ];

    // ====================== Relations For Community =================== //
    // Each job belongs to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ====================== Media =================== //
    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('job')->singleFile();
    }
}
