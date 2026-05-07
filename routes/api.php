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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/*
|-----------------------------------
| AUTH ROUTES (PUBLIC)
|-----------------------------------
*/
Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // ✅ FIXED: Forgot Password
    // Added 'statusCode' to JSON response so your Flutter app can read it
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json([
                'message' => __($status), 
                'statusCode' => 200
            ])
            : response()->json([
                'message' => __($status), 
                'statusCode' => 400 // Use 400 for user errors instead of 500
            ], 400);
    });

    // ✅ FIXED: Reset Password
    // Added 'statusCode' to JSON response
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
|-----------------------------------
| AUTHENTICATED ROUTES (SANCTUM)
|-----------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // USER PROFILE
    Route::get('/user', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |-----------------------------------
    | EMAIL VERIFICATION
    |-----------------------------------
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
    |-----------------------------------
    | USERS
    |-----------------------------------
    */
    Route::prefix('users')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
        Route::put('/profile', [UserController::class, 'update']);
        Route::get('/', [UserController::class, 'index']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });


    /*
    |-----------------------------------
    | EMOTIONS
    |-----------------------------------
    */
    Route::prefix('emotions')->group(function () {
        Route::get('/', [EmotionController::class, 'index']);
        Route::post('/', [EmotionController::class, 'store']);
    });


    /*
    |-----------------------------------
    | RECOMMENDATIONS
    |-----------------------------------
    */
    Route::prefix('recommendations')->group(function () {
        Route::get('/{emotion_id}', [RecommendationController::class, 'getByEmotion']);
        Route::post('/', [RecommendationController::class, 'store']);
    });


    /*
    |-----------------------------------
    | SESSIONS
    |-----------------------------------
    */
    Route::prefix('sessions')->group(function () {
        Route::post('/', [SessionController::class, 'store']);
        Route::get('/my-sessions', [SessionController::class, 'userSessions']);
        Route::get('/counselor-sessions', [SessionController::class, 'counselorSessions']);
    });


    /*
    |-----------------------------------
    | FEEDBACK
    |-----------------------------------
    */
    Route::prefix('feedback')->group(function () {
        Route::post('/', [FeedbackController::class, 'store']);
        Route::get('/', [FeedbackController::class, 'index']);
    });
    // Admin Dashboard Routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Users
    Route::get('/admin/users', [UserController::class, 'index']);
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);

    // Emotions (Assuming index returns all or update controller)
    Route::get('/admin/emotions', [EmotionController::class, 'index']);

    // Feedbacks
    Route::get('/admin/feedback', [FeedbackController::class, 'index']);

    // Sessions (Appointments)
    Route::get('/admin/sessions', [SessionController::class, 'index']); 

    // Journals (New)
    Route::get('/admin/journals', [JournalController::class, 'index']);
});
});