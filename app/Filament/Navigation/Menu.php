<?php

namespace App\Filament\Navigation;

use Filament\Navigation\NavigationItem;

class Menu
{
    public static function get(): array
    {
        return [
            NavigationItem::make('Dashboard')
                ->url(route('filament.pages.dashboard'))
                ->icon('heroicon-o-home'),

            NavigationItem::make('Settings')
                ->url(route('filament.pages.settings'))
                ->icon('heroicon-o-cog'),

            NavigationItem::make('Logout')
                ->action(function () {
                    auth()->logout();
                    return redirect('/');
                })
                ->icon('heroicon-o-arrow-left-on-square'),
        ];
    }
}