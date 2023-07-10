<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableTimes extends Model
{
    use HasFactory;

    protected $fillable = ['available_weekdays_id', 'start_time', 'end_time'];
}
