<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'counselor_id',
        'patient_name',
        'patient_phone',
        'patient_email',
        'service',
        'address',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
        'preferred_contact',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ✅ Fix for 422: Cast attributes properly
    protected function setCounselorIdAttribute($value)
    {
        $this->attributes['counselor_id'] = $value ? (int) $value : null;
    }

    // ✅ Fix for 500: Return user's name when accessed
    public function getPatientNameAttribute($value)
    {
        if (!$value && $this->user) {
            return $this->user->name;
        }
        return $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($appointment) {
            // Auto-generate patient name from user if not provided
            if (empty($appointment->patient_name) && $appointment->user_id) {
                $appointment->patient_name = $appointment->user->name ?? 'Unknown';
            }
            // Auto-generate phone from user if not provided
            if (empty($appointment->patient_phone) && $appointment->user) {
                $appointment->patient_phone = $appointment->user->contact ?? '';
            }
            // Auto-generate email from user if not provided
            if (empty($appointment->patient_email) && $appointment->user) {
                $appointment->patient_email = $appointment->user->email ?? '';
            }
        });
    }
}