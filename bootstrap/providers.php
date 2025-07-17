<?php

declare(strict_types=1);

use App\Providers\LastFmApiServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Providers\RouteServiceProvider::class,

    LastFmApiServiceProvider::class,
];
