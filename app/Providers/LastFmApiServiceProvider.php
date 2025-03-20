<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\ServiceProvider;

class LastFmApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LastFmApi::class, function (): LastFmApi {
            return new LastFmApi(
                config('services.lastfm.api_key')
            );
        });
    }
}
