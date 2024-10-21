<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charity extends BaseModel
{
    /**
     * Use the 'mind' database
     */
    protected $connection = 'mind';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'website',
        'email',
        'description',
    ];

    // ====================== Relations =================== //
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}