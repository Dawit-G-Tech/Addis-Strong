<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\ProfileController;

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
    return $request->user()->load('role');
});

// Profile management routes
Route::middleware('auth')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user()->load('role');
    });
    
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);
});

// Dashboard API routes
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/stats', [DashboardController::class, 'getStats']);
    Route::get('/recent-activity', [DashboardController::class, 'getRecentActivity']);
});

// Member API routes
Route::middleware('auth')->prefix('members')->group(function () {
    Route::get('/', [MemberController::class, 'index']);
    Route::post('/', [MemberController::class, 'store']);
    Route::get('/{member}', [MemberController::class, 'show']);
    Route::put('/{member}', [MemberController::class, 'update']);
    Route::delete('/{member}', [MemberController::class, 'destroy']);
});
