<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RtRwController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// list of auth route
Route::prefix('auth')->group(function () {

    // Register
    Route::prefix('register')->name('auth.register')->group(function () {

        // Ketua RT/RW
        Route::get('rt-rw', [AuthController::class, 'registerRtRwPage'])->name('.rt-rw');
        Route::post('rt-rw', [AuthController::class, 'register'])->name('.rt-rw.post');

        // Warga
        Route::get('warga', [AuthController::class, 'registerWargaPage'])->name('.warga');
        Route::post('warga', [AuthController::class, 'register'])->name('.warga.post');
    });

    // Complete Profile
    Route::prefix('complete-profile')->name('auth.complete-profile.')->group(function () {
        
        // Ketua RT/RW
        Route::get('rt-rw/{userId}', [AuthController::class, 'showRegisteredRtRw'])->name('rt-rw');
        Route::put('rt-rw/{userId}', [AuthController::class, 'completeProfile'])->name('rt-rw.post');

        // Warga
        Route::get('warga/{userId}', [AuthController::class, 'showRegisteredWarga'])->name('warga');
        Route::put('warga/{userId}', [AuthController::class, 'completeProfile'])->name('warga.post');
    });
    

    // Login
    Route::get('login', [AuthController::class, 'loginPage'])->name('auth.login');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login.post');

    // OTP
    Route::get('otp-verification', [AuthController::class, 'verifyOtpPage'])->name('auth.verify-otp');
    Route::post('otp-verification', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp.post');
    Route::get('otp-verification/resend', [AuthController::class, 'resetOtp'])->name('auth.otp-verification.resend');

    // Logout
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// list of sub-admin user route
Route::prefix('sub-admin')->name('sub-admin')->group(function () {
    Route::post('rt-rw', [RtRwController::class, 'store'])->name('.rt-rw.store');
})->middleware(['web']);

