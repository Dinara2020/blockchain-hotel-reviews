<?php

namespace HotelReviews\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $fillable = ['user_id', 'eth_address', 'eth_private_key'];

    protected $casts = [
        'eth_private_key' => 'encrypted',
    ];
}
