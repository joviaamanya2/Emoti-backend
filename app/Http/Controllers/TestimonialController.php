<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTestimonial;

class TestimonialController extends Controller
{
    public function feedback(Request $request)
    {
        $limit = $request->query('limit', 10);
        $session_type = $request->query('session_type');

        $query = UserTestimonial::whereNotNull('description')
            ->where('description', '!=', '')
            ->where('is_approved', 1);

        if ($session_type) {
            $query->where('session_type', $session_type);
        }

        $testimonials = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get([
                'id',
                'user_name',
                'session_type',
                'what_worked',
                'description',
                'star_rating',
                'mood_when_it_worked',
                'created_at'
            ]);

        return response()->json([
            "success" => true,
            "data" => $testimonials
        ]);
    }
}