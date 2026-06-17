<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTestimonial extends Model
{
    // REMOVED: public $timestamps = false; 
    // (Your migration has timestamps(), so we want Laravel to auto-manage them)

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
        'display_on_ui', // <--- ADDED
        // REMOVED 'created_at' and 'updated_at' from fillable 
        // because Laravel handles them automatically now
    ];

    // ADDED: Cast these to boolean so Filament Toggles work correctly
    protected $casts = [
        'is_approved' => 'boolean',
        'display_on_ui' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}