<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recommendation_id', // optional, tie to recommendation
        'session_id',        // optional, tie to session
        'rating',            // 1-5 stars
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
