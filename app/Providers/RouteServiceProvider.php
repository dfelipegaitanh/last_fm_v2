<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        $this->mapV1Routes();
        $this->mapLastFmRoutes();
    }

    protected function mapV1Routes(): void
    {
        Route::middleware('api')
            ->prefix('api/v1')
            ->group(base_path('routes/api_v1.php'));

    }

    protected function mapLastFmRoutes(): void
    {
        Route::middleware('auth:sanctum')
            ->prefix('last-fm')
            ->name('last-fm.')
            ->group(base_path('routes/last_fm.php'));

    }
}
