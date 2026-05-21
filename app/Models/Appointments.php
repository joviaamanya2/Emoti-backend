<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

// NOTE: Keep this class name as-is (Appointment). Some parts of the app
// reference App\Models\Appointments (plural). We provide an alias class below
// to prevent runtime "Class App\Models\Appointments not found" errors.


    protected $fillable = [
        'user_id',
        'title',
        'description',
        'appointment_time',
        'status',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// Alias to support code referencing App\Models\Appointments (plural).
// This prevents: Class "App\Models\Appointments" not found.
class Appointments extends Appointment
{
}

