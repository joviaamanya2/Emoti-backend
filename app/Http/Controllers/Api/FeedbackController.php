<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Submit feedback
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $feedback = Feedback::create([
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);

        return response()->json($feedback, 201);
    }

    // Admin view all feedback
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(Feedback::all());
    }
}