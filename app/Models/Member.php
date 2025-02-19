<?php

namespace App\Models;

class Member extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'mobile_number_view',
        'date_of_birth',
        'date_of_birth_view',
        'location',
        'location_view',
        'job',
        'job_view',
        'bio',
        'following_number',
        'followers_number',
        'points'
    ];

    // ====================== Relations For Community =================== //
    // Each member belong to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each member belong to many following
    public function following()
    {
        return $this->belongsToMany(Member::class, 'connections', 'followed_id', 'follower_id')->withPivot('is_followed');
    }

    // Each member belong to many followers
    public function followers()
    {
        return $this->belongsToMany(Member::class, 'connections', 'follower_id', 'followed_id')->withPivot('is_followed');
    }

    // Each member has many answers
    public function answers()
    {
        return $this->hasMany(MemberAnswer::class)->with('questions');
    }


    // Each member belong to many chats
    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_members');
    }

    
    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile')->singleFile();
        $this->addMediaCollection('cover')->singleFile();
    }
}
