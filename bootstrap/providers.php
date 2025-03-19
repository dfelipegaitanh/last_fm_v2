<?php

use App\Providers\LastFmApiServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Providers\RouteServiceProvider::class,

    LastFmApiServiceProvider::class,
];
