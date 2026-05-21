<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        return response()->json([
            'message' => 'OTP sent'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        return response()->json([
            'message' => 'OTP verified'
        ]);
    }

    public function resetPassword(Request $request)
    {
        return response()->json([
            'message' => 'Password reset successful'
        ]);
    }
}