<?php

use App\Http\Controllers\Api\KematianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PendudukController;
use App\Http\Controllers\Api\PekerjaanController;
use App\Http\Controllers\Api\KelahiranController;
use App\Http\Controllers\Api\JabatanController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\AnggotaKeluargaController;
use App\Http\Controllers\Api\StatusKeluargaController;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/penduduk/foto/{filename}', [PendudukController::class, 'getFoto']);
        Route::apiResource('/penduduk', PendudukController::class);
        Route::apiResource('/pekerjaan', PekerjaanController::class);
        Route::apiResource('/kelahiran', KelahiranController::class);
        Route::apiResource('/jabatan', JabatanController::class);
        Route::apiResource('/kematian', KematianController::class);

        Route::apiResource('/berita', BeritaController::class);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::apiResource('anggota-keluarga', AnggotaKeluargaController::class);
        Route::apiResource('status-keluarga', StatusKeluargaController::class);
    });
});