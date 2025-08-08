<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MembershipController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Member routes
Route::middleware(['auth'])->group(function () {
    Route::resource('members', MemberController::class);
    Route::get('/members/statistics', [MemberController::class, 'statistics'])->name('members.statistics');
});

// Staff routes
Route::middleware(['auth'])->group(function () {
    Route::resource('staff', StaffController::class);
    Route::get('/staff/statistics', [StaffController::class, 'statistics'])->name('staff.statistics');
});

// Class routes
Route::middleware(['auth'])->group(function () {
    Route::resource('classes', ClassController::class);
    Route::get('/classes/statistics', [ClassController::class, 'statistics'])->name('classes.statistics');
    Route::get('/classes/trainer/{trainerId}', [ClassController::class, 'byTrainer'])->name('classes.by-trainer');
});

// Payment routes
Route::middleware(['auth'])->group(function () {
    Route::resource('payments', PaymentController::class);
    Route::get('/payments/statistics', [PaymentController::class, 'statistics'])->name('payments.statistics');
    Route::get('/payments/member/{memberId}', [PaymentController::class, 'byMember'])->name('payments.by-member');
});

// Membership routes
Route::middleware(['auth'])->group(function () {
    Route::resource('memberships', MembershipController::class);
    Route::get('/memberships/statistics', [MembershipController::class, 'statistics'])->name('memberships.statistics');
});

// Dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', fn () => view('dashboards.user'))->name('user.dashboard');
    Route::get('/manager/dashboard', fn () => view('dashboards.manager'))->name('manager.dashboard');
    Route::get('/trainer/dashboard', fn () => view('dashboards.trainer'))->name('trainer.dashboard');
    Route::get('/admin/dashboard', fn () => view('dashboards.admin'))->name('admin.dashboard');
    Route::get('/member/dashboard', fn () => view('dashboards.member'))->name('member.dashboard');
    Route::get('/staff/dashboard', fn () => view('dashboards.staff'))->name('staff.dashboard');
    
    // Performance and statistics routes
    Route::get('/performance-reports', [DashboardController::class, 'performanceReports'])->name('performance.reports');
    Route::get('/attendance-stats', [DashboardController::class, 'attendanceStats'])->name('attendance.stats');
});

require __DIR__.'/auth.php';
