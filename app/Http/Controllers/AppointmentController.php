<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // GET all appointments
    public function index()
    {
        return response()->json(Appointment::with('user')->latest()->get());
    }

    // CREATE appointment
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'appointment_time' => 'required|date',
        ]);

        $appointment = Appointment::create($request->all());

        return response()->json([
            'message' => 'Appointment created successfully',
            'data' => $appointment
        ]);
    }

    // SHOW single appointment
    public function show($id)
    {
        return Appointment::with('user')->findOrFail($id);
    }

    // UPDATE appointment
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return response()->json([
            'message' => 'Appointment updated successfully',
            'data' => $appointment
        ]);
    }

    // DELETE appointment
    public function destroy($id)
    {
        Appointment::destroy($id);

        return response()->json([
            'message' => 'Appointment deleted successfully'
        ]);
    }
}