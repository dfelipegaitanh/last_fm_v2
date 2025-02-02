<?php

namespace App\Providers;

use App\Actions\LastFmGlobalSongsStatistics\GetGlobalSongsStatisticsAction;
use App\Actions\LastFmGlobalSongsStatistics\SaveGlobalSongsStatisticsAction;
use App\Actions\LastFmUser\GetUserInfoAction;
use App\Services\LastFmService;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SaveGlobalSongsStatisticsAction::class, function () {
            return new SaveGlobalSongsStatisticsAction();
        });

        $this->app->singleton(GetUserInfoAction::class, function () {
            return new GetUserInfoAction(
                app()->make(LastFmService::class),
                app()->make(SaveGlobalSongsStatisticsAction::class),
            );
        });

        $this->app->singleton(GetGlobalSongsStatisticsAction::class, function () {
            return new GetGlobalSongsStatisticsAction();
        });
    }

    public function boot(): void
    {
    }
}
