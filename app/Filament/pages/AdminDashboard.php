<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Admin Dashboard';
    protected static ?string $title = 'Admin Dashboard';
    protected static ?string $slug = 'admin-dashboard';

    protected static string $view = 'filament.pages.admin-dashboard';
}
?>
