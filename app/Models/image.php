<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'rating',
        'price',
        'is_visible',
        'fk_collection_id_dabartine',
        'fk_user_id_savininkas',
        'fk_user_id_kurejas',
        'image'
    ];
}
