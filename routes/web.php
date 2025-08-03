<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role->role_name;
    return match($role) {
        'Staff' => view('dashboards.admin'),
        'Trainer' => view('dashboards.trainer'),
        'Member' => view('dashboards.member'),
        'Manager' => view('dashboards.manager'),
        'User' => view('dashboards.user'),
        default => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

/* Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); */
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', fn () => view('dashboards.user'))->name('user.dashboard');
    Route::get('/manager/dashboard', fn () => view('dashboards.manager'))->name('manager.dashboard');
    Route::get('/trainer/dashboard', fn () => view('dashboards.trainer'))->name('trainer.dashboard');
    Route::get('/admin/dashboard', fn () => view('dashboards.admin'))->name('admin.dashboard');
    Route::get('/member/dashboard', fn () => view('dashboards.member'))->name('member.dashboard');
});



require __DIR__.'/auth.php';
