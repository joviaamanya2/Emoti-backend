<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emotion extends Model
{
    use HasFactory;
    protected $table = 'moods';

    // Updated fillable to include 'mood' and 'description'
    protected $fillable = [
        'user_id',
        'mood',        // e.g., happy, sad, angry
        'description', // optional description or notes
        'type',        // optional, if you want to keep it
        'intensity',   // optional numeric scale 1-10
        'notes',       // optional notes
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'mood_id');
    }
}