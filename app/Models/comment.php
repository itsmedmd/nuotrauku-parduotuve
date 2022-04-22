<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'fk_user_id',
        'fk_image_for_sale_id'
    ];
    protected $table = 'comments';
}
