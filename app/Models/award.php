<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class award extends Model
{
    use HasFactory;
    protected $fillable = [
        'prize_amount',
        'fk_user_id_laimetojas',
        'fk_image_id'
    ];
    protected $table = 'awards';
}
