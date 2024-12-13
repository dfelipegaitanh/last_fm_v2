<?php

use App\Livewire\LastFm\GetUser\GetUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::prefix('last-fm')
            ->name('last-fm.')
            ->group(function () {

                Route::get('/get-user', GetUser::class)
                    ->name('get-user');

            });

        Route::get('dashboard', function () {
            return redirect()->route('last-fm.get-user');
        })
            ->name('dashboard');

        Route::view('profile', 'profile')
            ->name('profile');
    });

require __DIR__.'/auth.php';
