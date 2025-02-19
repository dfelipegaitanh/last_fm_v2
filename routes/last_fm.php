<?php

use App\Http\Controllers\LastFm\UserGeInfoController;
use App\Http\Controllers\LastFm\UserGetStatisticsController;

Route::middleware('auth:sanctum')
    ->prefix('last-fm')
    ->name('last-fm.')
    ->group(function () {

        Route::view('user-info', 'last-fm.user_info')
            ->name('user_info');

        Route::get('user-get-statistics', UserGetStatisticsController::class)
            ->name('user_get_statistics');

        Route::get('user-get-info', UserGeInfoController::class)
            ->name('user_get_info');

    });
