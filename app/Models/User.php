<?php

namespace App\Models;

use App\Casts\DateFormateCasts;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements JWTSubject, HasMedia, LaratrustUser
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'is_active',
        'password',
        'brand_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => DateFormateCasts::class,
        'updated_at' => DateFormateCasts::class,
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // Spatie Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    // ======================== Relations For Community ======================== //
    // Each user has one member
    public function member()
    {
        return $this->hasOne(Member::class, 'user_id');
    }

    // Each user has many jobs
    public function jobs()
    {
        return $this->hasMany(JobAnnouncement::class, 'user_id');
    }

    // Each user has many buy and sells
    public function buy_sells()
    {
        return $this->hasMany(BuySell::class, 'user_id');
    }

    // Each user belong to card
    public function cards()
    {
        return $this->hasMany(Card::class, 'user_id');
    }

    // ======================== Relations For Suppliers ======================== //
    // Each supplier has one profile
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    // Each supplier has many branches
    public function branches()
    {
        return $this->hasMany(Branch::class, 'owner_id');
    }

    // Each user has one cashier
    public function cashier()
    {
        return $this->hasOne(Cashier::class, 'user_id');
    }

    // Each user has one cashier
    public function manager()
    {
        return $this->hasOne(Branch::class, 'manager_id');
    }

    public function setConnectionIfRequired($connection)
    {
        $this->setConnection($connection);
    }
}
