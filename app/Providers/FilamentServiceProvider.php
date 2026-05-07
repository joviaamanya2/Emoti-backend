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
      Filament::registerNavigationItems(Menu::get());
    }

    public function boot(): void
    {
        // Register custom CSS
        Filament::serving(function () {
            Filament::registerStyles([
                asset('css/filament.css'), // your green theme CSS
            ]);

            // Register sidebar navigation items dynamically
            Filament::registerNavigationItems([
                NavigationItem::make('Dashboard')
                    ->url(route('filament.pages.dashboard'))
                    ->icon('heroicon-o-home'),

                NavigationItem::make('Settings')
                    ->url(route('filament.pages.settings')) // create this page if it doesn't exist
                    ->icon('heroicon-o-cog'),

                NavigationItem::make('Logout')
                    ->action(function () {
                        auth()->logout();
                        return redirect('/'); // redirect to your app homepage after logout
                    })
                    ->icon('heroicon-o-arrow-left-on-square'),
            ]);

            // Register dashboard widgets
            Filament::registerWidgets([
                UserChartWidget::class,
            ]);
        });
    }
}