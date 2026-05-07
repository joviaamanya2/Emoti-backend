<?php

namespace App\Filament\Widgets;

use App\Models\Emotion;
use App\Models\Feedback;
use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Emotions', Emotion::count())
                ->description('Captured emotions'),

            Stat::make('Feedback Messages', Feedback::count())
                ->description('User feedback'),

            Stat::make('Appointments', Appointment::count())
                ->description('Counseling sessions'),
        ];
    }
}