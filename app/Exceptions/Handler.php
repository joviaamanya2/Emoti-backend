<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * IMPORTANT: Prevent redirecting API requests to login page
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }

    /**
     * Handle all exceptions as JSON for API requests
     */
    public function render($request, Throwable $exception)
    {
        // Always return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {

            // Validation errors
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $exception->errors()
                ], 422);
            }

            // 404 errors
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Route not found'
                ], 404);
            }

            // Default API error response
            return response()->json([
                'message' => $exception->getMessage() ?: 'Server Error'
            ], method_exists($exception, 'getStatusCode')
                ? $exception->getStatusCode()
                : 500);
        }

        return parent::render($request, $exception);
    }
}