<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        // Load routes from the specified files
        $this->loadRoutesFrom(base_path('routes/web.php'));
        $this->loadRoutesFrom(base_path('routes/api.php'));
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(60);
        });

        RateLimiter::for('api', function (Request $request) {
            $key = 'api-rate-limit:' . ($request->user()?->id ?? $request->ip());

            if (RateLimiter::tooManyAttempts($key, 30)) {
                return response()->json([
                    'message' => 'Too many requests, please try again later.'
                ], 429);
            }
            
            // Tambahkan satu hit
            RateLimiter::hit($key, 60); // 60 detik timeout
        });
    }
}
