<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// API routes for wilayah data
Route::prefix('api/wilayah')->group(function () {
    Route::get('/provinces', function () {
        $wilayahService = app(\App\Services\WilayahService::class);
        return response()->json($wilayahService->getProvinces());
    });

    Route::get('/regencies/{provinceId}', function ($provinceId) {
        $wilayahService = app(\App\Services\WilayahService::class);
        return response()->json($wilayahService->getRegencies($provinceId));
    });

    Route::get('/districts/{regencyId}', function ($regencyId) {
        $wilayahService = app(\App\Services\WilayahService::class);
        return response()->json($wilayahService->getDistricts($regencyId));
    });

    Route::get('/villages/{districtId}', function ($districtId) {
        $wilayahService = app(\App\Services\WilayahService::class);
        return response()->json($wilayahService->getVillages($districtId));
    });
});

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

