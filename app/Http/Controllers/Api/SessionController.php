<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    // Book session
    public function store(Request $request)
    {
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date'
        ]);

        $session = Session::create([
            'user_id' => auth()->id(),
            'counselor_id' => $request->counselor_id,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'pending'
        ]);

        return response()->json($session, 201);
    }

    // User sessions
    public function userSessions()
    {
        return response()->json(
            Session::where('user_id', auth()->id())->get()
        );
    }

    // Counselor sessions
    public function counselorSessions()
    {
        if (!auth()->user()->isCounselor()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(
            Session::where('counselor_id', auth()->id())->get()
        );
    }
}