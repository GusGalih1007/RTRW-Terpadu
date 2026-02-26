<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RtRwController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
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

    Route::get('forgot-password', [AuthController::class, 'forgotPasswordPage'])->name('auth.forgot-password');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password.post');

    Route::get('reset-password/user/{userId}', [AuthController::class, 'resetPasswordPage'])->name('auth.reset-password');
    Route::put('reset-password/user/{userId}', [AuthController::class, 'resetPassword'])->name('auth.reset-password.put');

    // OTP
    Route::get('otp-verification', [AuthController::class, 'verifyOtpPage'])->name('auth.verify-otp');
    Route::post('otp-verification', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp.post');
    Route::get('otp-verification/resend', [AuthController::class, 'resetOtp'])->name('auth.otp-verification.resend');

    // Logout
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// list of sub-admin user route
Route::prefix('sub-admin')->name('sub-admin')->group(function () {

    // RT/RW
    Route::post('rt-rw', [RtRwController::class, 'store'])->name('.rt-rw.store');
});

Route::prefix('admin')->name('admin.')->group(function () {
    
    // RT/RW
    Route::get('rt-rw', [RtRwController::class, 'index'])->name('rt-rw');
    Route::get('rt-rw/create', [RtRwController::class, 'create'])->name('rt-rw.create');
    Route::post('rt-rw', [RtRwController::class, 'store'])->name('rt-rw.store');
    Route::get('rt-rw/{id}/show', [RtRwController::class, 'show'])->name('rt-rw.show');
    Route::get('rt-rw/{id}/edit', [RtRwController::class, 'edit'])->name('rt-rw.edit');
    Route::put('rt-rw/{id}', [RtRwController::class, 'update'])->name(  'rt-rw.update');
    Route::delete('rt-rw/{id}', [RtRwController::class, 'destroy'])->name('rt-rw.delete');
});

// Test User CRUD
Route::prefix('user')->name('user')->group(function () {
    Route::get('', [UsersController::class, 'index'])->name('');
    Route::get('/create', [UsersController::class, 'create'])->name('.create');
    Route::post('', [UsersController::class, 'store'])->name('.store');
    Route::get('/{id}/profile', [UsersController::class, 'show'])->name('.profile');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('.edit');
    Route::put('/{id}', [UsersController::class, 'update'])->name('.update');
    Route::delete('/{id}', [UsersController::class, 'destroy'])->name('.delete');
});