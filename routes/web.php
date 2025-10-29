<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registration'])->name('registration');
    Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'loginUser'])->name('auth.login');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile-pic/update', [ProfileController::class, 'updateProfilePic'])->name('profilePic.update');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
