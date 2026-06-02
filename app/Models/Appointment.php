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
        'patient_phone',       // ✅ THIS WAS MISSING
        'contact_number',
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

    protected function setCounselorIdAttribute($value)
    {
        $this->attributes['counselor_id'] = $value ? (int) $value : null;
    }

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
            if (empty($appointment->patient_name) && $appointment->user_id) {
                $appointment->patient_name = $appointment->user->name ?? 'Unknown';
            }

            // ✅ Auto-fill contact_number from user if still empty
            if (empty($appointment->contact_number) && $appointment->user_id) {
                $appointment->contact_number = $appointment->user->contact ?? '';
            }

            if (empty($appointment->patient_phone) && $appointment->user_id) {
                $appointment->patient_phone = $appointment->user->contact ?? '';
            }

            if (empty($appointment->patient_email) && $appointment->user_id) {
                $appointment->patient_email = $appointment->user->email ?? '';
            }

            // ✅ Last resort: if contact_number still empty, copy from patient_phone
            if (empty($appointment->contact_number) && !empty($appointment->patient_phone)) {
                $appointment->contact_number = $appointment->patient_phone;
            }
        });
    }
}