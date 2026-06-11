<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Counselor;
use App\Models\Feedback;
use App\Models\Journal;
use App\Models\Recommendation;
use App\Models\User;
use Filament\Widgets\Widget;

class DashboardSummaryWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-summary';
    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'totalUsers' => User::count(),
            'appointments' => Appointment::count(),
            'counselors' => Counselor::count(),
            'recommendations' => Recommendation::count(),
            'feedbacks' => Feedback::count(),
            'journals' => Journal::count(),
        ];
    }
}
