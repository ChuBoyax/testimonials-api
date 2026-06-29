<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'role',
        'social',
        'rating',
        'message',
        'approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'approved' => 'boolean',
    ];
}
