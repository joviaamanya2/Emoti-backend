<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    
    // GET ALL APPOINTMENTS
    
    public function index()
    {
        $appointments = Appointment::with(['user', 'counselor'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $appointments,
        ], 200);
    }

    
    // GET USER APPOINTMENTS
    
    public function userAppointments()
    {
        $appointments = Appointment::with('counselor')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $appointments,
        ], 200);
    }

    
    // GET COUNSELOR APPOINTMENTS
    
    public function counselorAppointments()
    {
        $appointments = Appointment::with('user')
            ->where('counselor_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $appointments,
        ], 200);
    }

    
    // STORE APPOINTMENT
    
    public function store(Request $request)
{
    $validated = $request->validate([
        'counselor_id'      => 'nullable|integer',
        'patient_name'      => 'nullable|string|max:255',
        'patient_phone'     => 'nullable|string|max:20',
        'contact_number'    => 'nullable|string|max:20',
        'patient_email'     => 'nullable|email|max:255',
        'reason'           => 'required|string|max:255',
        'address'           => 'nullable|string',
        'appointment_date'  => 'required|date',
        'appointment_time'  => 'required|string|max:10',
        'notes'             => 'nullable|string',
        'preferred_contact' => 'nullable|string|max:50',
    ]);

    // If counselor_id is 0, treat it as not assigned
    if (
        isset($validated['counselor_id']) &&
        (int)$validated['counselor_id'] === 0
    ) {
        $validated['counselor_id'] = null;
    }

    // Ensure both phone fields are populated
    if (empty($validated['contact_number']) && !empty($validated['patient_phone'])) {
        $validated['contact_number'] = $validated['patient_phone'];
    }

    if (empty($validated['patient_phone']) && !empty($validated['contact_number'])) {
        $validated['patient_phone'] = $validated['contact_number'];
    }

    $validated['user_id'] = Auth::id();
    $validated['status'] = 'pending';

    $appointment = Appointment::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Appointment booked successfully',
        'data'    => $appointment,
    ], 201);
}
    
    // SHOW SINGLE APPOINTMENT
    
    public function show($id)
    {
        $appointment = Appointment::with(['user', 'counselor'])
            ->find($id);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $appointment,
        ], 200);
    }

    
    // UPDATE APPOINTMENT STATUS
    
    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found',
            ], 404);
        }

        $request->validate([
            'status' => 'required|string|in:pending,confirmed,cancelled,completed',
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return response()->json([
            'success' => true,
            'message' => 'Appointment updated successfully',
            'data'    => $appointment,
        ], 200);
    }

    
    // DELETE APPOINTMENT
    
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found',
            ], 404);
        }

        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appointment deleted successfully',
        ], 200);
    }
}