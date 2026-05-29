<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $code = random_int(100000, 999999);

        Log::info('===== OTP GENERATED =====');
        Log::info('Email: ' . $user->email);
        Log::info('Code: ' . $code);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $code,
                'created_at' => now(),
            ]
        );

        try {
            Mail::raw("Your Emoti verification code is: $code", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Emoti - Password Reset Code');
            });
            Log::info('Email sent successfully');
        } catch (\Exception $e) {
            Log::error('EMAIL FAILED: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to send email. Please try again.',
                'statusCode' => 500
            ], 500);
        }

        return response()->json([
            'message' => 'Verification code sent to your email.',
            'statusCode' => 200
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|numeric|digits:6',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$record) {
            return response()->json([
                'message' => 'Invalid verification code.',
                'statusCode' => 400
            ], 400);
        }

        if (now()->diffInMinutes($record->created_at) > 15) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'message' => 'Code expired. Request a new one.',
                'statusCode' => 400
            ], 400);
        }

        return response()->json([
            'message' => 'Code verified successfully.',
            'statusCode' => 200
        ]);
    }

        public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'code'                  => 'required|numeric|digits:6',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$record) {
            return response()->json([
                'message' => 'Invalid or expired code.',
                'statusCode' => 400
            ], 400);
        }

        if (now()->diffInMinutes($record->created_at) > 15) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'message' => 'Code expired. Request a new one.',
                'statusCode' => 400
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'message' => 'Password reset successfully.',
            'statusCode' => 200,
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }
}