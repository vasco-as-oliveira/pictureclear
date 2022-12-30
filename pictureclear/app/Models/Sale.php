<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'tier_id',       
    ];

    protected $hidden = [
        'user_id'
    ];

    protected $casts = [
        'bought' => 'datetime'
    ];
    
}