<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    // Allow these fields to be saved to the database
    protected $fillable = [
            'first_name', 
            'last_name', 
            'email', 
            'gender', 
            'birthdate', 
            'address', 
            'previous_school', 
            'preferred_course', 
            'status',
            'tracking_code',      // NEW
            'assigned_password'   // NEW
        ];
}