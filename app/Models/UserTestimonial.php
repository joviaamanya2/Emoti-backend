<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTestimonial extends Model
{
    protected $table = 'user_testimonials';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_name',
        'session_type',
        'what_worked',
        'description',
        'star_rating',
        'mood_when_it_worked',
        'is_approved',
        'helpful_count'
    ];

    // ← ADD THIS RELATIONSHIP
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}