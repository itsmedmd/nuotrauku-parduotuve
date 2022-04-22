<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'password',
        'email',
        'wallet_balance',
        'profile_picture',
        'is_blocked',
        'account_type'
    ];
    protected $table = 'users';
}
