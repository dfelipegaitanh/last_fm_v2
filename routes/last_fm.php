<?php

use App\Http\Controllers\LastFmController;

Route::middleware('auth')
    ->prefix('last-fm')
    ->name('last-fm.')
    ->group(function () {

        Route::get('user-info', [LastFmController::class , 'user_info'])
        ->name('user_info');

    });
