<?php

use App\Http\Controllers\Api\SyllabusController;
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
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user-profile', [AuthenticationController::class, 'userProfile']);
    Route::post('/profile', [AuthenticationController::class, 'profile']);
    Route::post('/change-password', [AuthenticationController::class, 'changePassword']);
    Route::group(['prefix' => 'syllabus'], function () {
        Route::get('/history', [SyllabusController::class, 'history']);
        Route::get('/history/{id}', [SyllabusController::class, 'historyDetail']); // Menggunakan {id} sebagai parameter
        Route::post('/generate', [SyllabusController::class, 'generate']);
        Route::post('/export-to-word', [SyllabusController::class, 'convertToWord']);
    });      
});

// Route for google log-in
Route::get('login/{provider}', [SocialiteController::class, 'redirect']);
Route::get('login/{provider}/callback', [SocialiteController::class, 'callback']);
Route::post('login/{provider}/callback', [SocialiteController::class, 'callback']);
