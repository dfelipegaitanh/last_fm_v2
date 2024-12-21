<?php

namespace App\Providers;

use App\Services\DateService;
use App\Services\LastFmService;
use Barryvanveen\Lastfm\Lastfm;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LastFmService::class, function () {
            return new LastFmService(
                app()->make(Lastfm::class),
            );
        });

        $this->app->singleton(DateService::class, function () {
            return new DateService;
        });
    }

    public function boot(): void
    {
    }
}
