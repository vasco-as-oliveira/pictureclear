<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = true;

    protected $fillable = [
        'owner_id',
        'language',
        'title',
        'description',
        'rating',
        'has_certificate',
        'total_hours',
    ];

    protected $hidden = [
        'owner_id'
    ];
    
}
