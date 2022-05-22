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
    public function scopeFilter($query, array $filters){
        // if not dont do anything
        if($filters['search'] ?? false){
            $query->where('name','like','%' . request('search') . '%')
            ->orWhere('description','like','%' . request('search') . '%');
        }
    }
    protected $table = 'collections';
}
