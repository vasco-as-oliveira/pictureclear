<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleSlots extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'schedule_id',
        'isFree',
        'begin',
        'end'
    ];
}
