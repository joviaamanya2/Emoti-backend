<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    // Get recommendations by emotion
    public function getByEmotion($emotion_id)
    {
        return response()->json(
            Recommendation::where('emotion_id', $emotion_id)->get()
        );
    }

    // Admin creating recommendation
public function store(Request $request) {
    $request->validate([
        'title' => 'required',
        'type' => 'required',
        'emotion' => 'required',
        'file' => 'nullable|mimes:mp4,mp3,jpeg,png|max:10240', // Allow specific file types
        'link' => 'nullable|url'
    ]);

    $data = $request->all();

    if ($request->hasFile('file')) {
        // Store in 'public/recommendations' folder
        $filePath = $request->file('file')->store('recommendations', 'public');
        $data['file_path'] = $filePath; // Assuming your DB column is file_path
    }

    Recommendation::create($data);
    return response()->json($data, 201);
}
}