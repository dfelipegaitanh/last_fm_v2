<?php

use App\Http\Controllers\LastFm\UserGeInfoController;
use App\Http\Controllers\LastFm\UserGetStatisticsController;
use App\Http\Controllers\LastFm\UserInfoController;

Route::get('user-info', UserInfoController::class)
    ->name('user_info');

Route::get('user-get-statistics', UserGetStatisticsController::class)
    ->name('user_get_statistics');

Route::get('user-get-info', UserGeInfoController::class)
    ->name('user_get_info');
