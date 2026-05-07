<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\User;

class UserChartWidget extends LineChartWidget
{
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