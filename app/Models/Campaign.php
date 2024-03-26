<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cause',
        'title',
        'description',
        'goal_amount',
        'current_amount',
        'start_date',
        'end_date',
        'beneficiary_name',
        'beneficiary_age',
        'beneficiary_city',
        'beneficiary_mobile',
        'status',
    ];
    
}
