<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\JsonResponse; // Import JsonResponse

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): JsonResponse // Changed from RedirectResponse
    {
        $validated = $request->validate([
            'token' => ['required'], // You need the token from the email
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // ✅ FIX: Return JSON based on status
        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'message' => __($status),
                'statusCode' => 200
            ], 200)
            : response()->json([
                'message' => __($status),
                'statusCode' => 400
            ], 400);
    }
}