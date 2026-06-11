<?php

namespace App\Filament\Widgets;

use App\Models\Emotion;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EmotionChart extends ChartWidget
{
    protected static string $view = 'filament.widgets.emotion-chart';
    public int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Emotion Trends (Current Month)';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $moods = ['happy', 'sad', 'lonely', 'stressed', 'angry'];
        $labels = [];
        $dates = [];
        $startOfMonth = now()->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $startOfMonth->copy()->addDays($day - 1);
            $labels[] = $date->format('j');
            $dates[] = $date->format('Y-m-d');
        }

        $raw = Emotion::selectRaw('DATE(mood_timestamp) as date, mood, COUNT(*) as total')
            ->whereIn('mood', $moods)
            ->whereMonth('mood_timestamp', now()->month)
            ->whereYear('mood_timestamp', now()->year)
            ->groupBy(DB::raw('DATE(mood_timestamp)'), 'mood')
            ->get()
            ->groupBy('mood');

        $datasets = [];
        $palette = [
            'happy'    => ['#10b981', 'rgba(16, 185, 129, 0.16)'],
            'sad'      => ['#3b82f6', 'rgba(59, 130, 246, 0.16)'],
            'lonely'   => ['#8b5cf6', 'rgba(139, 92, 246, 0.16)'],
            'stressed' => ['#f59e0b', 'rgba(245, 158, 11, 0.16)'],
            'angry'    => ['#ef4444', 'rgba(239, 68, 68, 0.16)'],
        ];

        foreach ($moods as $mood) {
            $values = [];
            $group = $raw->get($mood, collect())->keyBy('date');

            foreach ($dates as $date) {
                $values[] = $group->get($date)->total ?? 0;
            }

            $datasets[] = [
                'label' => ucfirst($mood),
                'data' => $values,
                'borderColor' => $palette[$mood][0],
                'backgroundColor' => $palette[$mood][1],
                'tension' => 0.35,
                'fill' => true,
                'pointRadius' => 2,
                'pointHoverRadius' => 5,
                'borderWidth' => 2,
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 12,
                        'padding' => 20,
                        'font' => ['size' => 13],
                        'color' => '#4b5563',
                        'usePointStyle' => true,
                        'pointStyleWidth' => 10,
                    ],
                ],
                'tooltip' => [
                    'backgroundColor' => '#064e3b',
                    'padding' => 14,
                    'cornerRadius' => 10,
                    'titleFont' => ['weight' => 'bold', 'size' => 14],
                    'bodyFont' => ['size' => 13],
                ],
            ],
            'scales' => [
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Day of Month',
                        'color' => '#6b7280',
                        'font' => ['size' => 13, 'weight' => '600'],
                    ],
                    'grid' => ['color' => 'rgba(0, 0, 0, 0.04)'],
                    'ticks' => ['color' => '#9ca3af', 'font' => ['size' => 12]],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Mood Records',
                        'color' => '#6b7280',
                        'font' => ['size' => 13, 'weight' => '600'],
                    ],
                    'ticks' => [
                        'precision' => 0,
                        'color' => '#9ca3af',
                        'font' => ['size' => 12],
                    ],
                    'grid' => ['color' => 'rgba(0, 0, 0, 0.04)'],
                ],
            ],
        ];
    }
}
