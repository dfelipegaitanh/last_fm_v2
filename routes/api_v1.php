<?php

declare(strict_types=1);

use App\Http\Controllers\Api\v1\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')
    ->post('logout', [AuthController::class, 'logout']);
