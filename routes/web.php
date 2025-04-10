<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;

// Authentication routes
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware([\App\Http\Middleware\ApiAuthentication::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User management
    Route::resource('users', UserController::class);
    
    // Role management
    Route::resource('roles', RoleController::class);
    
    // Division management
    Route::resource('divisions', DivisionController::class);
    
    // Position management
    Route::resource('positions', PositionController::class);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});