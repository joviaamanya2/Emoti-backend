<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Create default admin in local/testing only
        if ($this->app->environment(['local', 'testing'])) {
            if (! User::where('email', 'admin@emoti.com')->exists()) {
                User::create([
                    'name' => 'Super Admin',
                    'email' => 'admin@emoti.com',
                    'contact' => '0700000000',
                    'password' => Hash::make('123456'),
                    'role' => 'admin',
                ]);
            }
        }
    }
}