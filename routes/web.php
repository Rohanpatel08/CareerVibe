<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
Route::get('/job/detail/{id}', [JobController::class, 'details'])->name('job.details');
Route::post('/job/apply', [JobController::class, 'applyForJob'])->name('job.apply');

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

    // Job
    Route::get('/job/my-jobs', [JobController::class, 'myJobs'])->name('job.myJobs');
    Route::get('/job/create', [JobController::class, 'create'])->name('job.create');
    Route::post('/job/store', [JobController::class, 'store'])->name('job.store');
    Route::get('/job/edit/{id}', [JobController::class, 'edit'])->name('job.edit');
    Route::put('/job/update/{id}', [JobController::class, 'update'])->name('job.update');
    Route::post('/job/delete/{id}', [JobController::class, 'delete'])->name('job.delete');

    // Job Application
    Route::get('/job/my-job-applications', [JobController::class, 'myJobApplications'])->name('job.myJobApplications');
    Route::post('/job/my-job-applications/remove', [JobController::class, 'removeAppliedJobs'])->name('job.removeAppliedJobs');
});
