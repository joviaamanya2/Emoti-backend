<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function canAccessFilament(): bool
    {
        return true;
    }

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
    // ✅ Override to send 6-digit code instead of token
    public function sendPasswordResetNotification($token)
    {
        // Generate a 6-digit code
        $code = rand(100000, 999999);

        // Store the code in password_reset_tokens table
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $this->email],
            [
                'token' => $code,
                'created_at' => now(),
            ]
        );

        // Send the code via email
        $this->notify(new \App\Notifications\SendOtpNotification($code));
    }
     
}