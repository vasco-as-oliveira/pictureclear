<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $table = 'video';

  public $timestamps = true;

  protected $fillable = [
      'title', 'video'
  ];
}