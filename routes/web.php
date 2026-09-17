<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminStaffController;
use App\Http\Controllers\AdminTaskController;
use App\Http\Controllers\StaffPortalController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Admin Group
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Staff Management
        Route::resource('staff', AdminStaffController::class)->except(['create', 'show', 'edit']);
        
        // Task Management
        Route::resource('tasks', AdminTaskController::class)->except(['create', 'show', 'edit']);
    });

    // Staff Group
    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/tasks', [StaffPortalController::class, 'tasks'])->name('tasks.index');
        Route::patch('/tasks/{task}/status', [StaffPortalController::class, 'updateStatus'])->name('tasks.updateStatus');
        Route::get('/profile', [StaffPortalController::class, 'editProfile'])->name('profile');
        Route::patch('/profile', [StaffPortalController::class, 'updateProfile'])->name('profile.update');
    });
});