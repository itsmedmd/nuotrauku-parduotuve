<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image_rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'rating',
        'fk_user_id_vertintojas',
        'fk_image_id'
    ];
    protected $table = 'image_ratings';
}
