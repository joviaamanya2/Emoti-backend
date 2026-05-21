<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->path('admin')
            ->brandName('Emoti App')
            ->brandLogo(asset('images/emoti-logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/emoti-favicon.png'))
            
            // Explicitly registered resources in your desired order
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
                \App\Filament\Resources\TestimonialResource::class,
            ])
            
            // Sidebar group ordering/names
            ->navigationGroups([
                'Dashboard',
                'User Management',
                'User content',
                'Content library',
                'EMOTI MANAGEMENT',
                'COUNSELING',
                'USER CONTENT',
            ])
            
            // Your custom green theme CSS for Filament v2
            ->renderHook(
                'styles.before',
                fn (): string => '<style>
                    /* Login Page Green Gradient */
                    .fi-login {
                        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important;
                    }
                    
                    /* Sidebar Header Green */
                    .fi-sidebar-header {
                        background-color: #10b918 !important;
                    }
                    .fi-sidebar-header span {
                        color: #ffffff !important;
                    }
                    
                    /* Force Buttons Green */
                    .fi-btn-primary {
                        background-color: #10b918 !important;
                        border-color: #10b918 !important;
                    }
                    .fi-btn-primary:hover {
                        background-color: #059669 !important;
                    }
                </style>'
            );
    }
}