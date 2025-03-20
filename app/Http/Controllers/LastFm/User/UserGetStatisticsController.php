<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\User;

use App\Contracts\Actions\LastFm\Statistics\GetGlobalSongsStatisticsInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LastFm\User\GetUserStatisticsRequest;
use Illuminate\Http\JsonResponse;

class UserGetStatisticsController extends Controller
{
    public function __construct(
        private readonly GetGlobalSongsStatisticsInterface $getSongsStatistics
    ) {}

    public function __invoke(GetUserStatisticsRequest $request): JsonResponse
    {

        return response()->json(
            $this->getSongsStatistics->handle()
        );
    }
}
