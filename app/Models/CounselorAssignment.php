<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselorAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'counselor_id',
        'scheduled_at',
        'session_type',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    // Relationship to the Patient/User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to the Counselor
    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }
}