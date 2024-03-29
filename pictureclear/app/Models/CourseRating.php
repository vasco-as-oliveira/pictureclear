<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CourseRating extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'course_id',
        'rating',
    ];
}