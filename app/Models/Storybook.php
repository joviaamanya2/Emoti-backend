<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Storybook extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'storybooks';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'author',
        'reader',
        'image',
        'pages',
        'category',
        'is_active',
        'content',       // Added (used in your form)
        'age_group',     // Added (used in your form/table)
        'is_featured',   // Added (used in your form/table)
    ];

    protected $casts = [
        'pages' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean', // Added
    ];

    // Relationship to Emotion via pivot table 'emotion_storybook'
    public function emotions(): BelongsToMany
    {
        return $this->belongsToMany(Emotion::class, 'emotion_storybook', 'storybook_id', 'mood_id');
    }
}