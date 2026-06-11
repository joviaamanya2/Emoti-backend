<?php

namespace App\Filament\Widgets;

use App\Models\Emotion;
use App\Models\Journal;
use App\Models\UserTestimonial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Approved Testimonials', UserTestimonial::where('is_approved', 1)->count())
                ->description('Verified customer stories')
                ->descriptionIcon('heroicon-m-hand-raised')
                ->color('success'),

            Stat::make('Journal Entries', Journal::count())
                ->description('Mood and wellbeing notes')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Positive Mood Logs', Emotion::where('mood', 'happy')->count())
                ->description('Happy emotions recorded')
                ->descriptionIcon('heroicon-m-sun')
                ->color('success'),
        ];
    }
}