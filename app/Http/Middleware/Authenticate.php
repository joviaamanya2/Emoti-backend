<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Handle unauthenticated users
     */
    protected function redirectTo($request)
    {
        // IMPORTANT: Never redirect for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return null;
        }

        // Only for web routes (if any)
        return route('login');
    }
}