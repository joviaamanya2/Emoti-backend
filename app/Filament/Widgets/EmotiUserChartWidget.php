<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\LineChartWidget;

class EmotiUserChartWidget extends LineChartWidget
{
    public int|string|array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.user-chart';

    protected function getHeading(): string
    {
        return 'New Users This Month';
    }

    protected function getData(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;

        $usersPerDay = User::selectRaw('EXTRACT(DAY FROM created_at) as day, COUNT(*) as count')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->groupBy('day')
            ->pluck('count', 'day')
            ->toArray();

        $labels = [];
        $data = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $labels[] = $day;
            $data[] = $usersPerDay[$day] ?? 0;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'New users',
                    'data' => $data,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.16)',
                    'borderColor' => '#10b981',
                    'pointBackgroundColor' => '#047857',
                    'pointBorderColor' => '#10b981',
                    'tension' => 0.35,
                    'fill' => true,
                    'borderWidth' => 2,
                ],
            ],
        ];
    }
}