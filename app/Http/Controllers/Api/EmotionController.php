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
            'mood' => 'required|string',
            'emoji' => 'nullable|string',
        ]);

        $emotion = Emotion::create([
            'user_id' => auth()->id(),
            'mood' => $request->mood,
            'emoji' => $request->emoji ?? '',
            'mood_timestamp' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $emotion
        ], 201);
    }

    // Get logged-in user's emotions
    public function index()
    {
        $emotions = Emotion::where('user_id', auth()->id())->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $emotions
        ]);
    }
}