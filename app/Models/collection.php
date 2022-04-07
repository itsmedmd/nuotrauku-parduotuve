<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'fk_user_id_kurejas'
    ];
}
