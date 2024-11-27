<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'created_by',
    ];

    // ====================== Relations For Community =================== //
    public function members()
    {
        return $this->belongsToMany(User::class, 'chat_members');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
