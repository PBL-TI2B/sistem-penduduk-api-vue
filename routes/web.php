<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Master\PendudukController;
use App\Http\Controllers\Web\Master\PekerjaanController;
use App\Http\Controllers\Web\Master\DesaController;
use App\Http\Controllers\Web\Master\BantuanController;
use App\Http\Controllers\Web\Master\KurangMampuController;
use App\Http\Controllers\Web\Master\PenerimaBantuanController;
use App\Http\Middleware\EnsureUserIsAdmin;

Route::inertia('/', 'Beranda');
Route::inertia('/login', 'Auth/Login');

Route::inertia('/dashboard', 'Master/Dashboard');
Route::resource('/penduduk', PendudukController::class);
Route::resource('/pekerjaan', PekerjaanController::class);
Route::resource('/desa', DesaController::class);
Route::resource('/bantuan', BantuanController::class);
Route::resource('/kurang-mampu', KurangMampuController::class);
Route::resource('/penerima-bantuan', PenerimaBantuanController::class);

Route::inertia('/berita', 'Berita');
Route::inertia('/infografis/bansos', 'InfografisBansos');
Route::inertia('/infografis/penduduk', 'InfografisPenduduk');
Route::inertia('/profildesa', 'ProfilDesa');
Route::inertia('/galeri', 'Galeri');
Route::inertia('/detailberita', 'DetailBerita');
Route::inertia('/bansos', 'bansos');
