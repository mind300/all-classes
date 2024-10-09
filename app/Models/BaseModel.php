<?php

namespace App\Models;

use App\Casts\DateFormateCasts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BaseModel extends Model implements HasMedia
{
    use  HasFactory, Notifiable, InteractsWithMedia;

    protected $casts = [
        'created_at' => DateFormateCasts::class,
        'updated_at' => DateFormateCasts::class,
    ];
}
