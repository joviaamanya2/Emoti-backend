<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
