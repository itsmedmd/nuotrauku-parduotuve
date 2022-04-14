<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auction_bid extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
        'fk_auction_id',
        'fk_user_id'
    ];
}
