<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Emotion;
use App\Models\Recommendation;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class InsightWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-insight';
    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $totalEmotions = Emotion::count();
        $happyCount = Emotion::where('mood', 'happy')->count();

        $topEmotion = Emotion::select('mood', DB::raw('COUNT(*) as total'))
            ->groupBy('mood')
            ->orderByDesc('total')
            ->first();

        $busiestDay = Appointment::select(DB::raw("TRIM(TO_CHAR(created_at, 'Day')) as day"), DB::raw('COUNT(*) as total'))
            ->groupBy('day')
            ->orderByDesc('total')
            ->first();

        $todayNewUsers = User::whereDate('created_at', Carbon::today())->count();
        $recommendationCount = Recommendation::count();

        return [
            'topEmotion' => optional($topEmotion)->mood ? ucfirst($topEmotion->mood) : 'N/A',
            'topEmotionCount' => optional($topEmotion)->total ?? 0,
            'busiestDay' => optional($busiestDay)->day ?? 'No data yet',
            'todayNewUsers' => $todayNewUsers,
            'recommendationCount' => $recommendationCount,
            'happyPercent' => $totalEmotions > 0 ? round(($happyCount / $totalEmotions) * 100) : 0,
        ];
    }
}