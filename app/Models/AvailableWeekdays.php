<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableWeekdays extends Model
{
    use HasFactory;

    protected $fillable = ['sellers_id', 'day_of_week'];

    public function availableTimes()
    {
        return $this->hasMany(AvailableTimes::class);
    }
}
