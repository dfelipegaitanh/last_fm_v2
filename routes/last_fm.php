<?php

use App\Http\Controllers\LastFmGetStatisticsController;
use App\Http\Controllers\LastFmUserInfoController;

Route::middleware('auth')
    ->prefix('last-fm')
    ->name('last-fm.')
    ->group(function () {

        Route::get('user-info', LastFmUserInfoController::class)
            ->name('user_info');

        Route::get('user-get-statistics', LastFmGetStatisticsController::class)
            ->name('user_get_statistics');

    });
