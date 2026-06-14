<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emotion extends Model
{
    use HasFactory;
    protected $table = 'moods';

    // Updated fillable to include 'mood', 'description', 'emoji', 'mood_timestamp'
    protected $fillable = [
        'user_id',
        'mood',        // e.g., happy, sad, angry
        'emoji',       // 😊, 😟, etc.
        'mood_timestamp',
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
    public function videos()
    {
        // Arguments: Related Model, Pivot Table Name, Foreign Key of Current Model, Foreign Key of Related Model
        return $this->belongsToMany(Video::class, 'emotion_video', 'mood_id', 'video_id');
    }
}