<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\KematianController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PendudukController;
use App\Http\Controllers\Api\V1\PekerjaanController;
use App\Http\Controllers\Api\V1\KelahiranController;
use App\Http\Controllers\Api\V1\JabatanController;
use App\Http\Controllers\Api\V1\BeritaController;
use App\Http\Controllers\Api\V1\AnggotaKeluargaController;
use App\Http\Controllers\Api\V1\StatusKeluargaController;
use App\Http\Controllers\Api\V1\NotifikasiController;
use App\Http\Controllers\Api\V1\NotifikasiPenerimaController;

Route::prefix('v1')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/penduduk/foto/{filename}', [PendudukController::class, 'getFoto']);
        Route::apiResource('/penduduk', PendudukController::class);
        Route::apiResource('/pekerjaan', PekerjaanController::class);
        Route::apiResource('/kelahiran', KelahiranController::class);
        Route::apiResource('/jabatan', JabatanController::class);
        Route::apiResource('/kematian', KematianController::class);
        Route::apiResource('/notifikasi', NotifikasiController::class);
        Route::apiResource('/notifikasi-penerima', NotifikasiPenerimaController::class);
        Route::apiResource('/berita', BeritaController::class);
        Route::get('/auth/me', [AuthController::class, 'me'])->name('me');
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

        Route::apiResource('anggota-keluarga', AnggotaKeluargaController::class);
        Route::apiResource('status-keluarga', StatusKeluargaController::class);
    });
});