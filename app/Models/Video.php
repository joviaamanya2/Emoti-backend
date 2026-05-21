<?php

// app/Models/Video.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Video extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = [
        'title',
        'video_url',
        'category',
        'description',
        'duration',
        'is_featured',
        'is_active',
    ];
    
    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    public function emotions(): BelongsToMany
    {
        return $this->belongsToMany(Emotion::class);
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('video-thumbnails')
            ->singleFile();
    }
}
