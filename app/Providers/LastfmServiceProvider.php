<?php

declare(strict_types=1);

namespace App\Providers;

use App\Classes\Lastfm;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class LastfmServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     */
    public function boot() {}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Lastfm::class];
    }

    /**
     * Register any package services.
     */
    public function register()
    {

        $this->app->bind(Lastfm::class, function () {
            return new Lastfm(new Client, config('lastfm.api_key'));
        });
    }
}
