<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionRating;

class SessionRatingController extends Controller
{
    // Save a new rating
    public function store(Request $request)
    {
        $rating = SessionRating::create([
            'user_id' => $request->user_id,
            'session_type' => $request->session_type,
            'session_title' => $request->session_title,
            'emoji_rating' => $request->emoji_rating,
            'star_rating' => $request->star_rating,
            'feedback_text' => $request->feedback_text,
            'mood_at_start' => $request->mood_at_start
        ]);

        return response()->json([
            'message' => 'Rating saved successfully',
            'data' => $rating,
            'success' => true,
            'id' => $rating->id
        ]);
    }

    // Get all ratings
    public function index()
    {
        $ratings = SessionRating::latest()->get();

        return response()->json($ratings);
    }
    public function stats(Request $request)
    {
        $session_type = $request->query('session_type');

        if (!$session_type) {
            return response()->json([
                "success" => false,
                "error" => "Missing session_type"
            ]);
        }

        $stats = \App\Models\SessionRating::where('session_type', $session_type)
            ->selectRaw('COUNT(*) as total, AVG(emoji_rating) as avg_emoji, AVG(star_rating) as avg_star')
            ->first();

        return response()->json([
            "success" => true,
            "avg_emoji" => round((float) $stats->avg_emoji, 1),
            "avg_star" => round((float) $stats->avg_star, 1),
            "total" => (int) $stats->total
        ]);
    }
}