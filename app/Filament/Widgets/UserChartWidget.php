<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\LineChartWidget;

class UserChartWidget extends LineChartWidget
{
    protected int|string|array $columnSpan = 'half';

    protected static string $view = 'filament.widgets.user-chart';

    protected function getHeading(): string
    {
        return 'New Users This Month';
    }

    protected function getData(): array
    {
        $usersPerDay = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereMonth('created_at', now()->month)
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return [
            'labels' => array_keys($usersPerDay),
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => array_values($usersPerDay),
                    'backgroundColor' => '#28a745',
                    'borderColor' => '#28a745',
                ],
            ],
        ];
    }
}

