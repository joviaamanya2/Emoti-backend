<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

// Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EmotionController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\JournalController;
use App\Http\Controllers\Api\SessionRatingController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\StorybookController;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Forgot Password
    Route::post('/forgot-password', function (Request $request) {

        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json([
                'message' => __($status),
                'statusCode' => 200
            ])
            : response()->json([
                'message' => __($status),
                'statusCode' => 400
            ], 400);
    });

    // Reset Password
    Route::post('/reset-password', function (Request $request) {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'message' => 'Password reset successful',
                'statusCode' => 200
            ])
            : response()->json([
                'message' => 'Password reset failed',
                'statusCode' => 400
            ], 400);
    });

});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // USER AUTH
    Route::get('/user', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | EMAIL VERIFICATION
    |--------------------------------------------------------------------------
    */

    Route::post('/email/verification-notification', function (Request $request) {

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification email sent.'
        ]);

    });

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

        $request->fulfill();

        return response()->json([
            'message' => 'Email verified successfully.'
        ]);

    })->name('verification.verify');


    /*
    |--------------------------------------------------------------------------
    | OTP PASSWORD RESET
    |--------------------------------------------------------------------------
    */

    Route::post('/send-otp', [ForgotPasswordController::class, 'sendOtp']);
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);


    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */

    Route::prefix('users')->group(function () {

        Route::get('/', [UserController::class, 'index']);
        Route::get('/profile', [UserController::class, 'profile']);
        Route::put('/profile', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);

    });


    /*
    |--------------------------------------------------------------------------
    | EMOTIONS
    |--------------------------------------------------------------------------
    */

    Route::prefix('emotions')->group(function () {

        Route::get('/', [EmotionController::class, 'index']);
        Route::post('/', [EmotionController::class, 'store']);

    });


    /*
    |--------------------------------------------------------------------------
    | RECOMMENDATIONS
    |--------------------------------------------------------------------------
    */

    Route::prefix('recommendations')->group(function () {

        Route::get('/{emotion_id}', [RecommendationController::class, 'getByEmotion']);
        Route::post('/', [RecommendationController::class, 'store']);

    });


    /*
    |--------------------------------------------------------------------------
    | SESSIONS
    |--------------------------------------------------------------------------
    */

    Route::prefix('sessions')->group(function () {

        Route::post('/', [SessionController::class, 'store']);
        Route::get('/my-sessions', [SessionController::class, 'userSessions']);
        Route::get('/counselor-sessions', [SessionController::class, 'counselorSessions']);

    });


    /*
    |--------------------------------------------------------------------------
    | SESSION RATINGS
    |--------------------------------------------------------------------------
    */

    Route::get('/session-ratings', [SessionRatingController::class, 'index']);
    Route::post('/session-ratings', [SessionRatingController::class, 'store']);
    Route::get('/session-ratings/stats', [SessionRatingController::class, 'stats']);


    /*
    |--------------------------------------------------------------------------
    | TESTIMONIALS
    |--------------------------------------------------------------------------
    */

    Route::get('/testimonials', [TestimonialController::class, 'feedback']);


    /*
    |--------------------------------------------------------------------------
    | FEEDBACK
    |--------------------------------------------------------------------------
    */

    Route::prefix('feedback')->group(function () {

        Route::post('/', [FeedbackController::class, 'store']);
        Route::get('/', [FeedbackController::class, 'index']);

    });


    /*
    |--------------------------------------------------------------------------
    | JOURNALS
    |--------------------------------------------------------------------------
    */

    Route::get('/journals', [JournalController::class, 'index']);


    /*
    |--------------------------------------------------------------------------
    | STORY BOOKS
    |--------------------------------------------------------------------------
    */

    Route::get('/stories', [StorybookController::class, 'index']);
    Route::get('/stories/{id}', [StorybookController::class, 'show']);
    Route::get('/stories/search', [StorybookController::class, 'search']);
    Route::get('/stories/categories', [StorybookController::class, 'categories']);

    

Route::get('/appointments', [AppointmentController::class, 'index']);
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);

});