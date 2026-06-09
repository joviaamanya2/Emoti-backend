<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->path(config('filament.path', 'secure-panel'))
            ->brandName('Emoti App')
            ->brandLogo(asset('images/emoti-logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/emoti-favicon.png'))
            
            ->resources([
                // Dashboard

                // USER MANAGEMENT (Users/Admins/Counsellors)
                \App\Filament\Resources\UserResource::class,

                // USER CONTENT (Journal + Feedback)
                \App\Filament\Resources\JournalResource::class,
                \App\Filament\Resources\FeedbackResource::class,

                // CONTENT LIBRARY (Videos, Games, Story Books)
                \App\Filament\Resources\VideoResource::class,
                \App\Filament\Resources\GameResource::class,
                \App\Filament\Resources\StorybooksResource::class,

                // (Keep existing resources)
                \App\Filament\Resources\EmotionResource::class,
                \App\Filament\Resources\RecommendationResource::class,
                \App\Filament\Resources\CounselorResource::class,
                \App\Filament\Resources\CounselorAssignmentResource::class,
                \App\Filament\Resources\TestimonialResource::class,

                // COUNSELOR SESSION LOGS (Replaces old CounselorSessionResource)
                \App\Filament\Resources\CounselorSessionLogResource::class,
            ])
            
            ->navigationGroups([
                'Dashboard',
                'User Management',
                'User content',
                'Content library',
                'EMOTI MANAGEMENT',
                'COUNSELING',
                'Counseling Management', // Updated to match the new resource group
            ])
            
            ->renderHook(
                'styles.before',
                fn (): string => '<style>
                    /* Emoti green theme overrides */
                    .filament-login-page {
                        background-image: radial-gradient(circle at top, #d1fae5, #ecfdf5 50%);
                        background-repeat: no-repeat;
                    }

                    .dark .filament-login-page {
                        background-image: radial-gradient(circle at top, #064e3b, #065f46 50%, #0f172a 100%);
                    }

                    .filament-login-page form:before {
                        background-image: linear-gradient(to right, #ecfdf5, #10b918) !important;
                    }

                    .filament-sidebar-header,
                    .filament-sidebar-header:before {
                        background-image: linear-gradient(to right, #10b918, #059669) !important;
                    }

                    .filament-sidebar {
                        background-color: #064e3b !important;
                    }

                    .filament-sidebar a,
                    .filament-sidebar .filament-sidebar-group-label,
                    .filament-sidebar .filament-sidebar-item,
                    .filament-sidebar .filament-sidebar-item a {
                        color: #d1fae5 !important;
                    }

                    .filament-sidebar .filament-sidebar-item.active,
                    .filament-sidebar .filament-sidebar-item:hover,
                    .filament-sidebar .filament-sidebar-item a:hover {
                        background-color: rgba(16, 185, 24, 0.18) !important;
                        color: #ffffff !important;
                    }

                    .filament-button-primary,
                    .filament-button-primary:hover,
                    .filament-button-primary:focus {
                        background-color: #10b918 !important;
                        border-color: #10b918 !important;
                        color: #ffffff !important;
                    }

                    .filament-badge-primary,
                    .filament-badge-success {
                        background-color: #10b918 !important;
                        color: #ffffff !important;
                    }

                    .filament-card,
                    .filament-page-header,
                    .filament-topbar,
                    .filament-table {
                        border-color: rgba(16, 185, 24, 0.12) !important;
                    }

                    .filament-page-header h1,
                    .filament-page-header h2,
                    .filament-page-header h3,
                    .filament-card-header {
                        color: #064e3b !important;
                    }
                </style>'
            );
    }
}