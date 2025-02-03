<?php

use App\Http\Controllers\LastFm\GetStatisticsController;
use App\Http\Controllers\LastFm\UserInfoController;

Route::middleware('auth')
    ->prefix('last-fm')
    ->name('last-fm.')
    ->group(function () {

        Route::get('user-info', UserInfoController::class)
            ->name('user_info');

        Route::get('user-get-statistics', GetStatisticsController::class)
            ->name('user_get_statistics');

    });
