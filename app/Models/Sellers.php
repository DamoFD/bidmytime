<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Sellers extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function availableWeekdays()
    {
        return $this->hasMany(AvailableWeekdays::class);
    }

    public function availableExceptions()
    {
        return $this->hasMany(AvailableExceptions::class);
    }

    public function bids()
    {
        return $this->hasMany(Bids::class);
    }
}
