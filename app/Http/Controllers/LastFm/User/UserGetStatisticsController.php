<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\User;

use App\Contracts\Actions\LastFm\Statistics\GetGlobalSongsStatisticsInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserGetStatisticsController extends Controller
{
    public function __construct(
        private readonly GetGlobalSongsStatisticsInterface $getSongsStatistics
    ) {}

    public function __invoke(): JsonResponse
    {
        if (! auth()->user()) {
            return response()->json(['error' => 'User is not authenticated'], 401);
        }

        return response()->json(
            $this->getSongsStatistics->handle()
        );
    }
}
