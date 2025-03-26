<?php

declare(strict_types=1);

use App\Http\Controllers\LastFm\Charts\ListWeeklyChartsController;
use App\Http\Controllers\LastFm\Charts\ShowWeeklyChartController;
use App\Http\Controllers\LastFm\Charts\UserWeeklyChartsController;
use App\Http\Controllers\LastFm\User\UserGetInfoController;
use App\Http\Controllers\LastFm\User\UserGetStatisticsController;

Route::middleware('auth:sanctum')
    ->prefix('last-fm')
    ->name('last-fm.')
    ->group(function () {

        Route::view('user-info', 'last-fm.user-info')
            ->name('user-info');

        Route::get('user-get-statistics', UserGetStatisticsController::class)
            ->name('user_get_statistics');

        Route::get('user-get-info', UserGetInfoController::class)
            ->name('user_get_info');

        // Weekly Charts
//        Route::get('/weekly-charts', ListWeeklyChartsController::class)
//            ->name('last-fm.weekly-charts.index');

        Route::get('/weekly-charts/{from}/{to}', ShowWeeklyChartController::class)
            ->name('last-fm.weekly-charts.show');

        // User Weekly Charts
        Route::get('/users/{user}/weekly-charts', UserWeeklyChartsController::class)
            ->name('last-fm.users.weekly-charts');

    });
