<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MembershipController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('landing');



// Authentication routes
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth'])->group(function () {
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard routes with role-based access
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::resource('members', MemberController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('memberships', MembershipController::class);
    });

    // Manager routes
    Route::middleware(['role:manager'])->prefix('manager')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'managerDashboard'])->name('manager.dashboard');
        Route::resource('members', MemberController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('memberships', MembershipController::class);
    });

    // Trainer routes
    Route::middleware(['role:trainer'])->prefix('trainer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'trainerDashboard'])->name('trainer.dashboard');
        Route::get('/classes', [ClassController::class, 'myClasses'])->name('trainer.classes');
        Route::get('/sessions', [ClassController::class, 'mySessions'])->name('trainer.sessions');
    });

    // Staff routes
    Route::middleware(['role:staff'])->prefix('staff')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'staffDashboard'])->name('staff.dashboard');
        Route::get('/attendance', [MemberController::class, 'attendance'])->name('staff.attendance');
        Route::get('/equipment', [MemberController::class, 'equipment'])->name('staff.equipment');
    });

    // Member routes
    Route::middleware(['role:member'])->prefix('member')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'memberDashboard'])->name('member.dashboard');
        Route::get('/classes', [ClassController::class, 'availableClasses'])->name('member.classes');
        Route::get('/bookings', [ClassController::class, 'myBookings'])->name('member.bookings');
        Route::get('/payments', [PaymentController::class, 'myPayments'])->name('member.payments');
    });

    // User routes (default) - accessible to all authenticated users
    Route::prefix('user')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    });
});

// Vue.js SPA route (for API-based frontend)
Route::get('/app/{any?}', function () {
    return view('app');
})->where('any', '.*')->name('app');
