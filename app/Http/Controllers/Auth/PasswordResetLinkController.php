<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\JsonResponse; // 1. Import this

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse // 2. Change return type
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Send the link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // 3. Return JSON so Flutter understands it
        return $status === Password::RESET_LINK_SENT
            ? response()->json([
                'message' => 'Password reset link sent to your email!',
                'statusCode' => 200
            ])
            : response()->json([
                'message' => 'Unable to send reset link. Check email.',
                'statusCode' => 400
            ], 400);
    }
    
    // You can remove the 'create' method as it is not needed for API
}