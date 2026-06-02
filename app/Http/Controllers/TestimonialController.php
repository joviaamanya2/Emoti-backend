<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTestimonial;
use Carbon\Carbon;

class TestimonialController extends Controller
{
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
            // Generate a realistic placeholder avatar based on ID to remain consistent
            $avatarId = ($t->id % 5) + 1;
            $avatars = [
                1 => "https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80",
                2 => "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80",
                3 => "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&q=80",
                4 => "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=100&q=80",
                5 => "https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=100&q=80",
            ];
            $avatar = $avatars[$avatarId] ?? $avatars[1];

            // Calculate dynamic days ago
            $createdAt = Carbon::parse($t->created_at);
            $daysAgo = $createdAt->diffInDays(Carbon::now());

            return [
                'id' => $t->id,
                'name' => $t->user_name ?? 'Anonymous',
                'avatar' => $avatar,
                'mood' => $t->mood_when_it_worked ?? 'Great',
                'content' => $t->description ?? '',
                'whatWorked' => $t->what_worked ?? 'General',
                'daysAgo' => (int)$daysAgo,
                'rating' => (int)($t->star_rating ?? 5),
            ];
        });

        return response()->json([
            "success" => true,
            "data" => $mapped
        ]);
    }
}