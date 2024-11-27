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

    // ====================== Relations =================== //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function following()
    {
        return $this->belongsToMany(Member::class, 'connections', 'followed_id', 'follower_id')->withPivot('is_followed');
    }

    public function followers()
    {
        return $this->belongsToMany(Member::class, 'connections', 'follower_id', 'followed_id')->withPivot('is_followed');
    }
    
    public function answers()
    {
        return $this->hasMany(MemberAnswer::class,);
    }
}
