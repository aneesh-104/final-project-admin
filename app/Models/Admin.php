<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;



class Admin extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    protected $table = 'admins';
    // Define the columns that are mass assignable
    protected $fillable = [
        'username', 'password', 'security_token',
    ];

    // Define the columns that should be hidden
    protected $hidden = [
        'password',
    ];
}
