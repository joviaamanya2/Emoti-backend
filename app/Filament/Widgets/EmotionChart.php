<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class EmotionChart extends ChartWidget
{
    protected int|string|array $columnSpan = 'half';

    protected static ?string $heading = 'Emotion Distribution';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Happy',
                    'data' => [65, 59, 80, 81, 56, 85, 90],
                    'borderColor' => '#5dcc53',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
                [
                    'label' => 'Sad',
                    'data' => [28, 48, 40, 19, 46, 27, 30],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'transparent',
                    'tension' => 0.4,
                    'borderDash' => [5, 5],
                ],
                [
                    'label' => 'Angry',
                    'data' => [10, 15, 20, 10, 25, 10, 5],
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'transparent',
                    'tension' => 0.4,
                ],
            ],
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        ];
    }
}

