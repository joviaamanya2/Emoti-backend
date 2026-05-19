<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Emotion;
use App\Models\Session;

class EmotiStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Registered app users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'), // Uses your primary green color
                
            Stat::make('Emotions Logged', Emotion::count())
                ->description('Total emotion entries')
                ->descriptionIcon('heroicon-m-face-smile')
                ->color('success'),

            Stat::make('Counseling Sessions', Session::count())
                ->description('Total sessions booked')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
        ];
    }
}