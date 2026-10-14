<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmailOtpController;
use App\Http\Controllers\CourseStudyScheduleController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [EmailOtpController::class, 'register'])
    ->name('register');

Route::post('/verify-otp', [EmailOtpController::class, 'verify'])
    ->name('otp.verify');

Route::post('/resend-otp', [EmailOtpController::class, 'resend'])
    ->name('otp.resend');

Route::post('/login', [EmailOtpController::class, 'login'])
    ->name('auth.login');

Route::middleware('auth')->group(function () {
    Route::get('/account', [EmailOtpController::class, 'account'])->name('account.show');
    Route::patch('/account/profile', [EmailOtpController::class, 'updateProfile'])->name('account.profile.update');
    Route::patch('/account/password', [EmailOtpController::class, 'updatePassword'])->name('account.password.update');
    Route::post('/logout', [EmailOtpController::class, 'logout'])->name('auth.logout');
    Route::get('/study-schedules', [CourseStudyScheduleController::class, 'index'])->name('study-schedules.index');
    Route::post('/study-schedules', [CourseStudyScheduleController::class, 'store'])->name('study-schedules.store');
    Route::delete('/study-schedules/{schedule}', [CourseStudyScheduleController::class, 'destroy'])->name('study-schedules.destroy');
});
