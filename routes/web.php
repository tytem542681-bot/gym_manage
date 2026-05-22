<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GymMemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Compatibility route expected by auth/tests: route('dashboard')
// Maps to the authenticated user's role dashboard.
Route::middleware('auth')->get('/dashboard', function () {
    // Tests expect the canonical redirect URL to remain `/dashboard`.
    // Render the role-specific dashboard view instead of redirecting.
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return app('App\\Http\\Controllers\\AdminController')->dashboard();
    }

    if ($role === 'staff') {
        return app('App\\Http\\Controllers\\StaffController')->dashboard();
    }

    return app('App\\Http\\Controllers\\ClientController')->dashboard();
})->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () { 
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [AdminController::class, 'attendance'])->name('attendance');
    Route::get('/activities', [AdminController::class, 'activities'])->name('activities');
    Route::resource('members', GymMemberController::class);
});

Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [StaffController::class, 'attendance'])->name('attendance');
    Route::get('/activities', [StaffController::class, 'activities'])->name('activities');
    Route::get('/members', [GymMemberController::class, 'index'])->name('members.index');
    Route::get('/members/create', [GymMemberController::class, 'create'])->name('members.create');
    Route::post('/members', [GymMemberController::class, 'store'])->name('members.store');
    Route::get('/members/{member}', [GymMemberController::class, 'show'])->name('members.show');
});

Route::middleware('auth')->get('/members', [GymMemberController::class, 'index'])->name('members.index');

Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ClientController::class, 'profile'])->name('profile');
    Route::get('/attendance', [ClientController::class, 'attendance'])->name('attendance');
    Route::post('/attendance/check-in', [ClientController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/attendance/check-out', [ClientController::class, 'checkOut'])->name('attendance.check-out');
    Route::get('/membership-history', [ClientController::class, 'membershipHistory'])->name('membership-history');
    Route::get('/change-plan', [ClientController::class, 'showChangePlan'])->name('change-plan');
    Route::post('/change-plan', [ClientController::class, 'changePlan'])->name('change-plan.store');
    Route::get('/renew', [App\Http\Controllers\Client\RenewController::class, 'index'])->name('renew');
    Route::post('/renew', [App\Http\Controllers\Client\RenewController::class, 'renew'])->name('renew');
    Route::get('/support', [ClientController::class, 'support'])->name('support');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/select-plan', [ClientController::class, 'selectPlan'])->name('client.select-plan');
    Route::post('/client/select-plan', [ClientController::class, 'selectPlanStore'])->name('client.select-plan-action');
});

require __DIR__.'/auth.php';
