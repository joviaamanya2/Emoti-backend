<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            
            // --- 1. THEME COLORS (GREEN) ---
            ->colors([
                'primary' => Color::Emerald, 
            ])
            
            // --- 2. BRAND & CUSTOM CSS ---
->brandName('Emoti App')
            ->renderHook(
                PanelsRenderHook::HEAD_START, 
                fn () => '<style>
                    /* Theme: Green/Black/White */
                    .fi-sidebar-header {
                        background-color: #10b981 !important;
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
                        color: #047857 !important;
                    }
                    .fi-sidebar-item.active {
                        background-color: #d1fae5 !important;
                        color: #047857 !important;
                        border-right: 3px solid #10b981;
                    }

                    /* Primary buttons */
                    :root {
                        --primary-500: #10b981;
                    }
                    .fi-button {
                        border-radius: 0.5rem;
                    }
                </style>'
            )

            // --- 3. REGISTER RESOURCES, PAGES & WIDGETS ---
            ->resources([
                \App\Filament\Resources\AppointmentResource::class,
                \App\Filament\Resources\CounselorResource::class,
                \App\Filament\Resources\EmotionResource::class,
                \App\Filament\Resources\RecommendationResource::class,
                \App\Filament\Resources\FeedbackResource::class,
                \App\Filament\Resources\UserResource::class,
                \App\Filament\Resources\AdminResource::class,
            ])
            ->pages([
                \App\Filament\Pages\Dashboard::class,
                \App\Filament\Pages\Settings::class,
            ])
            ->widgets([
                \App\Filament\Widgets\DashboardStats::class,
                \App\Filament\Widgets\EmotionChart::class,
                \App\Filament\Widgets\UserChartWidget::class,
            ])
            
            // --- 4. AUTH MIDDLEWARE ---
            ->authMiddleware([
                Authenticate::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ]);
    }
}