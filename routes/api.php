<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\KematianController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PendudukController;
use App\Http\Controllers\Api\V1\PerangkatDesaController;
use App\Http\Controllers\Api\V1\RwController;
use App\Http\Controllers\Api\V1\RtController;
use App\Http\Controllers\Api\V1\DusunController;
use App\Http\Controllers\Api\V1\DesaController;
use App\Http\Controllers\Api\V1\PekerjaanController;
use App\Http\Controllers\Api\V1\KelahiranController;
use App\Http\Controllers\Api\V1\JabatanController;
use App\Http\Controllers\Api\V1\PeriodeJabatanController;
use App\Http\Controllers\Api\V1\BeritaController;
use App\Http\Controllers\Api\V1\AnggotaKeluargaController;
use App\Http\Controllers\Api\V1\StatusKeluargaController;

Route::prefix('v1')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/penduduk/foto/{filename}', [PendudukController::class, 'getFoto']);
        Route::apiResource('/penduduk', PendudukController::class);
        Route::apiResource('/perangkat-desa', PerangkatDesaController::class);
        Route::apiResource('/rw', RwController::class);
        Route::apiResource('/rt', RtController::class);
        Route::apiResource('/dusun', DusunController::class);
        Route::apiResource('/desa', DesaController::class);
        Route::apiResource('/pekerjaan', PekerjaanController::class);
        Route::apiResource('/kelahiran', KelahiranController::class);
        Route::apiResource('/jabatan', JabatanController::class);
        Route::apiResource('/periode-jabatan', PeriodeJabatanController::class);
        Route::apiResource('/kematian', KematianController::class);

        Route::apiResource('/berita', BeritaController::class);
        Route::get('/auth/me', [AuthController::class, 'me'])->name('me');
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

        Route::apiResource('anggota-keluarga', AnggotaKeluargaController::class);
        Route::apiResource('status-keluarga', StatusKeluargaController::class);
    });
});