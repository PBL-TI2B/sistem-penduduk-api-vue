<?php

use App\Http\Controllers\Web\Master\KelahiranController;
use App\Http\Controllers\Web\Master\KematianController;
use App\Http\Controllers\Web\Master\PendidikanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Master\PendudukController;
use App\Http\Controllers\Web\Master\PerangkatDesaController;
use App\Http\Controllers\Web\Master\PekerjaanController;
use App\Http\Controllers\Web\Master\DesaController;
use App\Http\Controllers\Web\Master\DusunController;
use App\Http\Controllers\Web\Master\BantuanController;
use App\Http\Controllers\Web\Master\KurangMampuController;
use App\Http\Controllers\Web\Master\PenerimaBantuanController;
use App\Http\Controllers\Web\Master\GaleriController;
use App\Http\Controllers\Web\Master\BeritaController;
use App\Http\Controllers\Web\Master\KategoriBantuanController;
use App\Http\Controllers\Web\Master\KeluargaController;
use App\Http\Controllers\Web\Master\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;

Route::inertia('/', 'Beranda');
Route::inertia('/login', 'Auth/Login');
Route::inertia('/berita', 'Berita');
Route::inertia('/infografis', 'Infografis');
Route::inertia('/profildesa', 'ProfilDesa');
Route::inertia('/galeri', 'Galeri');
Route::inertia('/detailberita', 'DetailBerita');

Route::prefix('/admin')->group(function () {
        Route::inertia('/dashboard', 'Master/Dashboard');
        Route::resource('/user', UserController::class);
        Route::resource('/penduduk', PendudukController::class);
        Route::resource('/perangkat-desa', PerangkatDesaController::class);
        Route::resource('/keluarga', KeluargaController::class);
        Route::resource('/pekerjaan', PekerjaanController::class);
        Route::resource('/desa', DesaController::class);
        Route::resource('/dusun', DusunController::class);
        Route::resource('/bantuan', BantuanController::class);
        Route::resource('/kelahiran', KelahiranController::class);
        Route::resource('/kematian', KematianController::class);
        Route::resource('/kurang-mampu', KurangMampuController::class);
        Route::resource('/penerima-bantuan', PenerimaBantuanController::class);
        Route::resource('/pendidikan', PendidikanController::class);
        Route::resource('/galeri', GaleriController::class);
        Route::resource('/berita', BeritaController::class);    
});
