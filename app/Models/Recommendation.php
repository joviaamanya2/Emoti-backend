<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'mood_id',
        'title',
        'description',
        'type',
        'video_path',
        'music_path',
        'tips_text',
        'is_active',
        'file',
        'link',
    ];

    public function emotion(): BelongsTo
    {
        return $this->belongsTo(Emotion::class);
    }
    public function mood()
    {
        return $this->belongsTo(Emotion::class, 'mood_id');
    }
}