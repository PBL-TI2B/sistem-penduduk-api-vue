<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PendudukController;
use App\Http\Controllers\Api\JabatanController;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function(){
        Route::apiResource('/penduduk', PendudukController::class);
        Route::apiResource('/jabatan', JabatanController::class);

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
