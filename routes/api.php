<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpAuthController;
use App\Http\Controllers\Api\UserController;

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

// Public routes
Route::post('/send-otp', [OtpAuthController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpAuthController::class, 'verifyOtp']);

// Category routes (public)
Route::get('/categories', [UserController::class, 'index']);
Route::get('/categories/{id}', [UserController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [OtpAuthController::class, 'logout']);

    // Protected category routes (if you want to add authenticated-only category endpoints later)
    // Route::post('/categories', [UserController::class, 'store']);
    // Route::put('/categories/{id}', [UserController::class, 'update']);
    // Route::delete('/categories/{id}', [UserController::class, 'destroy']);
});
