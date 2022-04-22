<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image_for_sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
        'fk_image_id'
    ];
    protected $table = 'images_for_sale';
}
