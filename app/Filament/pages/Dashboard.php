<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget;
use App\Models\User;
use App\Models\Emotion; // Make sure these models exist
use App\Models\Session; // Make sure these models exist

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Emoti Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-heart';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\DashboardSummaryWidget::class,
            \App\Filament\Widgets\EmotionChart::class,
            \App\Filament\Widgets\EmotiUserChartWidget::class,
        ];
    }

}