<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTestimonial extends Model
{
    public $timestamps = false;
    protected $table = 'user_testimonials';
    protected $fillable = [
        'user_id',
        'user_name',
        'session_type',
        'what_worked',
        'description',
        'emoji',
        'star_rating',
        'mood_when_it_worked',
        'is_approved',
        'helpful_count',
        'display_name_type',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}