<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home');
Route::inertia('/dashboard', 'Master/Dashboard');
Route::inertia('/penduduk', 'Master/Penduduk');
