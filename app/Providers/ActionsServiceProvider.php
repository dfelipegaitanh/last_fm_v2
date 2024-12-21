<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
//        $this->app->singleton(SaveGlobalSongsStatisticsAction::class, function () {
//            return new SaveGlobalSongsStatisticsAction;
//        });
//
//        $this->app->singleton(GetUserInfoAction::class, function () {
//            return new GetUserInfoAction;
//        });
//
//        $this->app->singleton(GetGlobalSongsStatisticsAction::class, function () {
//            return new GetGlobalSongsStatisticsAction;
//        });
    }

    public function boot(): void
    {
    }
}
