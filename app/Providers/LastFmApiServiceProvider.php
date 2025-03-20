<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\LastFm\Statistics\GetGlobalSongsStatistics;
use App\Contracts\Actions\LastFm\Statistics\GetGlobalSongsStatisticsInterface;
use App\Actions\LastFm\Users\GetUserInfo;
use App\Contracts\Actions\LastFm\Users\GetUserInfoInterface;
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

        $this->app->bind(GetUserInfoInterface::class, GetUserInfo::class);
        $this->app->bind(GetGlobalSongsStatisticsInterface::class, GetGlobalSongsStatistics::class);
    }
}
