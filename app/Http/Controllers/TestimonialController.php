<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTestimonial;
use Carbon\Carbon;

class TestimonialController extends Controller
{
    /**
     * Store a newly created testimonial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mood'                => 'required|string|max:50',
            'emoji'               => 'nullable|string|max:10',
            'text'                => 'nullable|string|max:1000', 
            'what_worked'         => 'nullable|string|max:255',
            'star_rating'         => 'nullable|integer|min:1|max:5',
            'user_name'           => 'nullable|string|max:255',
            'session_type'        => 'nullable|string|max:255',
            'display_name_type'   => 'nullable|string|max:50',
        ]);

        $user = $request->user();

        $testimonial = UserTestimonial::create([
            'user_id'             => $user ? $user->id : null,  // ✅ Now allowed (nullable column)
            'user_name'           => $validated['user_name'] ?? ($user ? $user->name : 'Anonymous'),
            'description'         => $validated['text'] ?? null,           
            'session_type'        => $validated['session_type'] ?? $validated['mood'],
            'mood_when_it_worked' => $validated['mood'],  
            'emoji'               => $validated['emoji'] ?? null,           
            'what_worked'         => $validated['what_worked'] ?? 'General',
            'star_rating'         => $validated['star_rating'] ?? 5,
            'is_approved'         => 0,                              
            'helpful_count'       => 0,
            'display_name_type'   => $validated['display_name_type'] ?? 'anonymous',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial submitted successfully!',
            'data'    => $testimonial,
        ], 201);
    }

    /**
     * Fetch approved testimonials.
     */
    public function feedback(Request $request)
    {
        $limit = $request->query('limit', 10);
        $session_type = $request->query('session_type');
        $mood = $request->query('mood');

        $query = UserTestimonial::whereNotNull('description')
            ->where('description', '!=', '')
            ->where('is_approved', 1);

        if ($session_type) {
            $query->where('session_type', $session_type);
        }

        if ($mood) {
            $query->where('mood_when_it_worked', $mood);
        }

        $testimonials = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $mapped = $testimonials->map(function ($t) {
            $avatarId = ($t->id % 5) + 1;
            $avatars = [
                1 => "https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80",
                2 => "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80",
                3 => "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80",
                4 => "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=100&q=80",
                5 => "https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=100&q=80",
            ];
            $avatar = $avatars[$avatarId] ?? $avatars[1];

            $daysAgo = 0;
            if ($t->created_at) {
                $daysAgo = Carbon::parse($t->created_at)->diffInDays(Carbon::now());
            }

            return [
                'id'                 => $t->id,
                'user_name'          => $t->user_name ?? 'Anonymous',
                'avatar'             => $avatar,
                'mood_when_it_worked'=> $t->mood_when_it_worked ?? 'General',
                'mood'               => $t->mood_when_it_worked ?? 'General', 
                'emoji'              => $t->emoji ?? '',
                'session_type'       => $t->session_type ?? 'General',
                'description'        => $t->description ?? '',
                'content'            => $t->description ?? '', 
                'what_worked'        => $t->what_worked ?? 'General',
                'whatWorked'         => $t->what_worked ?? 'General', 
                'star_rating'        => (int)($t->star_rating ?? 5),
                'rating'             => (int)($t->star_rating ?? 5), 
                'helpful_count'      => (int)($t->helpful_count ?? 0),
                'helpfulCount'       => (int)($t->helpful_count ?? 0), 
                'display_name_type'  => $t->display_name_type ?? 'anonymous',
                'daysAgo'            => (int)$daysAgo, 
            ];
        });

        return response()->json([
            "success" => true,
            "data" => $mapped
        ]);
    }
}