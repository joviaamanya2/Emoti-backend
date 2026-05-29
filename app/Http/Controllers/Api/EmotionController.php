<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emotion;
use Illuminate\Http\Request;

class EmotionController extends Controller
{
    // Store emotion
    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|string'
        ]);

        $emotion = Mood::create([
            'user_id' => auth()->id(),
            'mood' => $request->mood
        ]);

        return response()->json($emotion, 201);
    }

    // Get logged-in user's emotions
    public function index()
    {
        return response()->json(
            Mood::where('user_id', auth()->id())->latest()->get()
        );
    }
}