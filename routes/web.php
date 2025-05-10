<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Master\PendudukController;
use App\Http\Controllers\Web\Master\PekerjaanController;
use App\Http\Controllers\Web\Master\DesaController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureTokenAuthenticated;

Route::inertia('/', 'Beranda');
Route::inertia('/', 'Beranda');
Route::inertia('/login', 'Auth/Login');

Route::inertia('/dashboard', 'Master/Dashboard');
Route::resource('/penduduk', PendudukController::class);
Route::resource('/pekerjaan', PekerjaanController::class);
Route::resource('/desa', DesaController::class);

Route::inertia('/berita', 'Berita');
Route::inertia('/infografis', 'Infografis');
Route::inertia('/profildesa', 'ProfilDesa');
Route::inertia('/galeri', 'Galeri');
Route::inertia('/detailberita', 'DetailBerita');
Route::inertia('/bansos', 'bansos');