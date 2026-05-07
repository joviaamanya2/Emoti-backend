<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Filament access
     */
    public function canAccessFilament(): bool
    {
        return true;
    }

    // Relationships

    public function emotions()
    {
        return $this->hasMany(Emotion::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id');
    }

    public function counselorSessions()
    {
        return $this->hasMany(Session::class, 'counselor_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    // Role helpers

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCounselor()
    {
        return $this->role === 'counselor';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}