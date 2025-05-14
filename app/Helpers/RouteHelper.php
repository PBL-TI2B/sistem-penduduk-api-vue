<?php
use Illuminate\Support\Facades\Route;

function RoutePermission($path, $controller, $model, $publicGet = false) {
    Route::prefix($path)->group(function () use ($path, $controller, $model, $publicGet) {
        if ($publicGet) {
            Route::get('/', [$controller, 'index']);
            Route::get('/{' . $model . '}', [$controller, 'show']);
        } else {
            Route::get('/', [$controller, 'index'])->middleware("auth:sanctum");
            Route::get('/{' . $model . '}', [$controller, 'show'])->middleware("auth:sanctum");
        }

        Route::post('/', [$controller, 'store'])
            ->middleware(["auth:sanctum", "permission:{$path}.create"]);

        Route::put('/{' . $model . '}', [$controller, 'update'])
            ->middleware(["auth:sanctum", "permission:{$path}.update"]);

        Route::delete('/{' . $model . '}', [$controller, 'destroy'])
            ->middleware(["auth:sanctum", "permission:{$path}.delete"]);
    });
}
