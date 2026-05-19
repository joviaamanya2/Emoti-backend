<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            
            // --- 1. EMOTI GREEN THEME ---
            ->colors([
                'primary' => Color::hex('#10b918'), // Your exact Emoti Green
            ])
            
            // --- 2. BRAND, LOGO & FAVICON ---
            ->brandName('Emoti App')
            ->brandLogo(asset('images/emoti-logo.png')) 
            ->brandLogoHeight('3rem') 
            ->favicon(asset('images/emoti-favicon.png'))

            // --- 3. YOUR CUSTOM GREEN CSS ---
            ->renderHook(
                'styles.before',
                fn (): string => '<style>
                    /* Emoti Theme: Green/White/Black */
                    .fi-sidebar-header {
                        background-color: #10b918 !important;
                        color: #fff !important;
                        padding: 1.5rem 1rem;
                        display: flex;
                        align-items: center;
                        gap: 0.75rem;
                        font-weight: 700;
                        text-transform: uppercase;
                        letter-spacing: 0.05em;
                    }
                    .fi-sidebar-header .fi-sidebar-brand-text { color: #fff !important; }

                    .fi-sidebar {
                        background-color: #ffffff !important;
                        color: #000000 !important;
                    }

                    .fi-sidebar-item {
                        transition: all 0.2s ease;
                    }
                    .fi-sidebar-item:hover {
                        background-color: #ecfdf5 !important;
                        color: #047842 !important;
                    }
                    .fi-sidebar-item.active {
                        background-color: #d1fae5 !important;
                        color: #08926b !important;
                        border-right: 3px solid #10b981;
                    }

                    /* Primary buttons */
                    :root {
                        --primary-500: #10b918;
                    }
                    .fi-button {
                        border-radius: 0.5rem;
                    }
                </style>'
            )

            // --- 4. AUTO-DISCOVER (Prevents Class Not Found Errors) ---
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \Filament\Widgets\AccountWidget::class,
                \Filament\Widgets\FilamentInfoWidget::class,
            ])
            
            // --- 5. CLEAN MIDDLEWARE ---
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ])
            ->authMiddleware([
                \Illuminate\Auth\Middleware\Authenticate::class,
            ]);
    }
}