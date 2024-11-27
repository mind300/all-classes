<?php

namespace App\Models;

class MemberAnswer extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'answer',
        'community_question_id',
        'member_id',
    ];

    // ====================== Relations For Community =================== //
    public function questions()
    {
        return $this->belongsTo(CommunityQuestion::class, 'community_question_id');
    }
}
