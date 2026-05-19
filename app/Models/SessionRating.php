<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionRating extends Model
{
    protected $table = 'session_ratings';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'session_type',
        'session_title',
        'emoji_rating',
        'star_rating',
        'feedback_text',
        'mood_at_start'
    ];
}