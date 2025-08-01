<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "api" middleware group. Make something great!
// |
// */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpAuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/send-otp', [OtpAuthController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpAuthController::class, 'verifyOtp']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [OtpAuthController::class, 'logout']);
});

// Categories routes
Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
Route::get('/categories/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'show']);
Route::get('/categories/parent/{parentId}', [CategoryController::class, 'getByParent']);
