<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselorSessionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'counselor_id',
        'counselor_name',
        'counselor_email',
        'counselor_contact',
        'client_name',
        'specification',
        'session_notes',
        'screenshot_path',
    ];

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}