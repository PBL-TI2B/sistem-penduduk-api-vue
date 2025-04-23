<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\PendudukController;

Route::inertia('/', 'Home');
Route::inertia('/dashboard', 'Master/Dashboard');
Route::inertia('/login', 'Auth/Login');

Route::resource('/penduduk', PendudukController::class);
