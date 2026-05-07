<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Emotion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Users chart: last 7 days
        $usersChart = [
            'labels' => [],
            'data' => [],
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $usersChart['labels'][] = $date;
            $usersChart['data'][] = User::whereDate('created_at', $date)->count();
        }

        // Emotions chart
        $emotionsChart = [
            'labels' => ['Happy','Sad','Angry'],
            'data' => [
                Emotion::where('mood','happy')->count(),
                Emotion::where('mood','sad')->count(),
                Emotion::where('mood','angry')->count(),
            ]
        ];

        return view('dashboard', compact('usersChart','emotionsChart'));
    }
}