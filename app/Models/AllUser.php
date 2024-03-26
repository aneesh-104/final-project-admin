<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AllUser extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'allusers'; // If your table name is 'allusers'

    protected $fillable = [
        'name',
        'email',
        'dob',
        'age',
        'sex',
        'pan',
        'balance',
        'address',
        'city',
        'profile_picture',
        'role',
        'password',
        'description',
    ];

    protected $hidden = [
        'password',
    ];


    protected $casts = [
        'password' => 'hashed',
    ];
}
