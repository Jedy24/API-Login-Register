<?php

use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\SyllabusController;
use App\Http\Controllers\Api\UserStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\SocialiteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API routes for register & login
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Public routes of authentication
Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/verify-otp', 'verifyOtp');
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
    Route::post('/resend-otp', 'resendOtp');
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user-profile', [AuthenticationController::class, 'userProfile']);
    Route::get('/user-status', [UserStatusController::class, 'getStatus']);
    Route::post('/profile', [AuthenticationController::class, 'profile']);
    Route::post('/change-password', [AuthenticationController::class, 'changePassword']);
    Route::post('/update-profile', [AuthenticationController::class, 'updateProfile']);
    Route::group(['prefix' => 'syllabus'], function () {
        Route::get('/history', [SyllabusController::class, 'mtHandler']);
        Route::get('/history/{id}', [SyllabusController::class, 'mtHandler']);
        Route::post('/generate', [SyllabusController::class, 'mtHandler']);
        Route::post('/export-to-word', [SyllabusController::class, 'mtHandler']);
    });
    Route::group(['prefix' => 'material'], function () {
        Route::post('/generate', [MaterialController::class, 'generate']);
        Route::post('/export-word', [MaterialController::class, 'convertToWord']);
        Route::get('/history', [MaterialController::class, 'history']);
        Route::get('/history/{id}', [MaterialController::class, 'historyDetail']);
    });
    Route::group(['prefix' => 'exercise'], function () {
        Route::post('/generate-essay', [ExerciseController::class, 'generateEssay']);
    });
});


// Route for google log-in
Route::get('login/{provider}', [SocialiteController::class, 'redirect']);
Route::get('login/{provider}/callback', [SocialiteController::class, 'callback']);
Route::post('login/{provider}/callback', [SocialiteController::class, 'callback']);
