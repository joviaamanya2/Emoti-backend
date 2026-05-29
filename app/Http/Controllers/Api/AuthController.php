<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;  // ← WAS MISSING
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // --------------------------------
    // REGISTER
    // --------------------------------
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'in:user,counselor,admin',
            'contact' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $role = $request->role ?? 'user';

        if ($role === 'admin') {
            return response()->json([
                'message' => 'Admin accounts cannot be created publicly.'
            ], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'contact' => $request->contact,
            'address' => $request->address,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // --------------------------------
    // LOGIN
    // --------------------------------
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    // --------------------------------
    // LOGOUT
    // --------------------------------
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    // --------------------------------
    // FORGOT PASSWORD (Send OTP)
    // --------------------------------
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // This triggers sendPasswordResetNotification() on the User model
        $user->sendPasswordResetNotification('');

        return response()->json([
            'message' => 'Verification code sent to your email.',
        ], 200);
    }

    // --------------------------------
    // VERIFY OTP (Fixed - Removed Duplicate)
    // --------------------------------
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|digits:6',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$record) {
            return response()->json([
                'message' => 'Invalid verification code.',
            ], 400);
        }

        // Check if code has expired (15 minutes)
        if (now()->diffInMinutes($record->created_at) > 15) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'message' => 'Verification code has expired. Please request a new one.',
            ], 400);
        }

        // ✅ Return data object - Flutter expects this format
        return response()->json([
            'message' => 'Code verified successfully.',
            'data' => [
                'verified' => true
            ]
        ], 200);
    }

    // --------------------------------
    // RESET PASSWORD (Fixed - Returns User Data)
    // --------------------------------
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'code'                  => 'required|digits:6',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);

        // Verify the code again
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$record) {
            return response()->json([
                'message' => 'Invalid or expired verification code.',
            ], 400);
        }

        // Check expiration
        if (now()->diffInMinutes($record->created_at) > 15) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'message' => 'Code has expired. Please request a new one.',
            ], 400);
        }

        // Update the password
        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete the used token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // ✅ Return user data - Flutter needs this to show the name
        return response()->json([
            'message' => 'Password reset successfully. You can now login with your new password.',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ], 200);
    }
}