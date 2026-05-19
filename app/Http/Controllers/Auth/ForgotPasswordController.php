<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = (string) rand(100000, 999999);

        DB::table('password_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new SendOtpMail($otp));

        return response()->json([
            'message' => 'OTP sent successfully',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
        ]);

        $record = DB::table('password_otps')
            ->where('email', $request->email)
            ->first();

        if (!$record || (string) $record->otp !== (string) $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        if (Carbon::now()->gt($record->expires_at)) {
            return response()->json(['message' => 'OTP expired'], 400);
        }

        return response()->json(['message' => 'OTP verified'], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_otps')
            ->where('email', $request->email)
            ->first();

        if (!$record || (string) $record->otp !== (string) $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        if (Carbon::now()->gt($record->expires_at)) {
            return response()->json(['message' => 'OTP expired'], 400);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        DB::table('password_otps')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successful'], 200);
    }
}

