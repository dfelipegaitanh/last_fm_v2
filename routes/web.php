<?php

use App\Livewire\Index\Index;
use App\Livewire\LastFm\GetUser\Index as LastFmGetUserIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::prefix('last-fm')
            ->name('last-fm.')
            ->group(function () {

                Route::get('/get-user', LastFmGetUserIndex::class)
                    ->name('get-user');

            });

        Route::get('dashboard', Index::class)
            ->name('dashboard');

        Route::view('profile', 'profile')
            ->name('profile');
    });

require __DIR__.'/auth.php';
