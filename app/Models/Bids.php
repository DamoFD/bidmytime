<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sellers_id', 'bid_date', 'start_time', 'end_time', 'amount'];

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'sellers_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
