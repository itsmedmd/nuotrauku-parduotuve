<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auction extends Model
{
    use HasFactory;
    protected $fillable = [
        'end_date',
        'price',
        'initial_price',
        'minimum_bid_raise',
        'status',
        'fk_image_id'
    ];
}
