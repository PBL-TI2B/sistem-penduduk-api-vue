<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Master\PendudukController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureTokenAuthenticated;

Route::inertia('/', 'Beranda');
Route::inertia('/', 'Beranda');
Route::inertia('/login', 'Auth/Login');

Route::inertia('/dashboard', 'Master/Dashboard');
Route::resource('/penduduk', PendudukController::class);

Route::inertia('/infografis/bansos', 'InfografisBansos');
Route::inertia('/infografis/penduduk', 'InfografisPenduduk');
Route::inertia('/berita', 'Berita');
Route::inertia('/profildesa', 'ProfilDesa');
Route::inertia('/galeri', 'Galeri');
Route::inertia('/detailberita', 'DetailBerita');
