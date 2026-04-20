<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'section_id', 'school_year'];

    // This connects the enrollment to the Student (User)
    public function student() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ADD THIS NEW METHOD: It connects the enrollment to the Section
    public function section() {
        return $this->belongsTo(Section::class, 'section_id');
    }
}