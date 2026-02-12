<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RtRwController;

// API routes for wilayah data
Route::prefix('wilayah')->group(function () {
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

// API routes for RT/RW data
Route::get('/rt-rw/kelurahan/{kelurahanId}', [RtRwController::class, 'apiGetByKelurahan'])->name('api.rt-rw.getRtrwByKelurahan');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
