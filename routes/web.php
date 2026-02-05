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
    Route::get('register', [AuthController::class, 'registerPage'])->name('auth.register');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register.post');
    Route::get('login', [AuthController::class, 'loginPage'])->name('auth.login');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login.post');
    Route::get('complete-profile/user/{userId}', [AuthController::class, 'showRegisteredProfile'])->name('auth.complete-profile');
    Route::put('complete-profile/user/{userId}', [AuthController::class, 'completeProfile'])->name('auth.complete-profile.post');
    Route::get('otp-verification', [AuthController::class, 'verifyOtpPage'])->name('auth.verify-otp');
    Route::post('otp-verification', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp.post');
    Route::get('otp-verification/resend', [AuthController::class, 'resetOtp'])->name('auth.otp-verification.resend');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});
