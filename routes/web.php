<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Master\PendudukController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureTokenAuthenticated;

Route::inertia('/', 'Home');
Route::inertia('/login', 'Auth/Login');

    Route::inertia('/dashboard', 'Master/Dashboard');
    Route::resource('/penduduk', PendudukController::class);