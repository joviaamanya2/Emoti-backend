<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use App\Filament\Widgets\UserChartWidget;
use Filament\Navigation\NavigationItem;
use App\Filament\Navigation\Menu;

class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // 
    }

    public function boot(): void
    {
        // Register custom CSS
        Filament::serving(function () {
            Filament::registerStyles([
                asset('css/filament.css'), // your green theme CSS
            ]);

            // Register navigation groups in explicit order
            Filament::registerNavigationGroups([
                'User Management',
                'User Content',
                'Content Library',
                'Emoti Management',
                'Counseling Management',
                'Counseling',
            ]);

            // Register dashboard widgets
            Filament::registerWidgets([
                UserChartWidget::class,
            ]);
        });
    }
}