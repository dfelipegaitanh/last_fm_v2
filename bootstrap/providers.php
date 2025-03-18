<?php

use App\Providers\LastFmApiServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\LastfmServiceProvider::class,

    LastFmApiServiceProvider::class,
];
