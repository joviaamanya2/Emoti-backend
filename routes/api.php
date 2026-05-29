<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Hash;

// Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EmotionController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\CounselorSessionController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\JournalController;
use App\Http\Controllers\Api\SessionRatingController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\StorybookController;
use App\Http\Controllers\AppointmentController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (NO AUTH REQUIRED)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Password Reset with 6-digit OTP
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Public testimonials
Route::get('/testimonials', [TestimonialController::class, 'feedback']);


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // User Auth
    Route::get('/user', [AuthController::class, 'profile']);
    Route::post('/auth/logout', [AuthController::class, 'logout']); // Fixed path to match Flutter

    // Email Verification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification email sent.']);
    });

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['message' => 'Email verified successfully.']);
    })->name('verification.verify');
    

    // Inside your auth:sanctum middleware group:
    Route::get('/appointments/user', [AppointmentController::class, 'userAppointments']);
    Route::get('/appointments/counselor', [AppointmentController::class, 'counselorAppointments']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/profile', [UserController::class, 'profile']);
        Route::put('/profile', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    // Change Password (Outside 'users' prefix so it matches /user/password exactly)
    Route::put('/user/password', [UserController::class, 'changePassword']);

    // Emotions
    Route::prefix('emotions')->group(function () {
        Route::get('/', [EmotionController::class, 'index']);
        Route::post('/', [EmotionController::class, 'store']);
    });

    // Recommendations
    Route::prefix('recommendations')->group(function () {
        Route::get('/{emotion_id}', [RecommendationController::class, 'getByEmotion']);
        Route::post('/', [RecommendationController::class, 'store']);
    });

    // Sessions
    Route::prefix('sessions')->group(function () {
        Route::post('/', [CounselorSessionController::class, 'store']);
        Route::get('/my-sessions', [CounselorSessionController::class, 'userSessions']);
        Route::get('/counselor-sessions', [CounselorSessionController::class, 'counselorSessions']);
    });

    // Session Ratings
    Route::get('/session-ratings', [SessionRatingController::class, 'index']);
    Route::post('/session-ratings', [SessionRatingController::class, 'store']);
    Route::get('/session-ratings/stats', [SessionRatingController::class, 'stats']);

    // Testimonials & Feedback
    Route::get('/feedback', [TestimonialController::class, 'feedback']);
    Route::prefix('feedback')->group(function () {
        Route::post('/', [FeedbackController::class, 'store']);
        Route::get('/', [FeedbackController::class, 'index']);
    });

    // Journals
    Route::get('/journals', [JournalController::class, 'index']);

    // Storybooks
    Route::get('/stories', [StorybookController::class, 'index']);
    Route::get('/stories/{id}', [StorybookController::class, 'show']);
    Route::get('/stories/search', [StorybookController::class, 'search']);
    Route::get('/stories/categories', [StorybookController::class, 'categories']);

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
});