<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

        protected $fillable = [
                'section_name',
                'course',         // NEW
                'max_capacity',
                'adviser_id'
            ];

        // Add this relationship so we can get the adviser's name
        public function adviser() {
            return $this->belongsTo(User::class, 'adviser_id');
        }
}