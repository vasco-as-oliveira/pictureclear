<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = true;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'url',
    ];

    
}
