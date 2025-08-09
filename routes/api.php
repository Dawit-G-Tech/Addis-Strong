<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\MembershipController;

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

// Dashboard API routes
Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

// Members API routes
Route::apiResource('members', MemberController::class);

// Staff API routes
Route::apiResource('staff', StaffController::class);

// Classes API routes
Route::apiResource('classes', ClassController::class);

// Payments API routes
Route::apiResource('payments', PaymentController::class);

// Memberships API routes
Route::apiResource('memberships', MembershipController::class);
