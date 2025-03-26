<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\Charts;

use App\Actions\LastFm\FetchWeeklyChartList;
use App\Http\Requests\LastFm\Charts\ListWeeklyChartsRequest;
use Exception;
use Illuminate\Http\JsonResponse;

readonly class ListWeeklyChartsController
{
    public function __construct(
        private FetchWeeklyChartList $fetchWeeklyChartList
    ) {}

    public function __invoke(ListWeeklyChartsRequest $request): JsonResponse
    {
        $user = auth()->user();

        try {
            $charts = $this->fetchWeeklyChartList->handle($user->lastfm_user);

            return response()->json($charts);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
