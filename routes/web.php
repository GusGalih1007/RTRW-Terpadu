<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('auth')->group(function () {
    Route::get('register', [AuthController::class, 'registerPage'])->name('auth.register');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register.post');
    Route::get('login', [AuthController::class, 'loginPage'])->name('auth.login');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login.post');
    Route::get('show-qr/user/{userId}', [AuthController::class, 'showQrImage'])->name('auth.show-user-qr');
    Route::get('otp-verification', [AuthController::class, 'verifyOtpPage'])->name('auth.verify-otp');
    Route::post('otp-verification', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp.post');
    Route::get('otp-verification/resend', [AuthController::class, 'resetOtp'])->name('auth.otp-verification.resend');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});
