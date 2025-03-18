<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Api\LastFm\LastFmApi;
use Illuminate\Support\ServiceProvider;

class LastFmApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LastFmApi::class, function () {
            return new LastFmApi(
                config('services.lastfm.api_key')
            );
        });
    }
}
