<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\Charts;

use App\Actions\LastFm\Charts\ProcessWeeklyTrackChart;
use App\Http\Requests\LastFm\Charts\ShowWeeklyChartRequest;
use Exception;
use Illuminate\Http\JsonResponse;

readonly class ShowWeeklyChartController
{
    public function __construct(
        private ProcessWeeklyTrackChart $processWeeklyTrackChart
    ) {}

    public function __invoke(ShowWeeklyChartRequest $request, int $from, int $to): JsonResponse
    {
        $user = auth()->user();

        try {
            $weeklyChart = $this->processWeeklyTrackChart->handle($from, $to);
            $tracks = $weeklyChart->tracksForUser($user)->get();

            return response()->json([
                'chart' => [
                    'from' => $weeklyChart->from_timestamp,
                    'to' => $weeklyChart->to_timestamp,
                    'from_formatted' => $weeklyChart->fromFormatted,
                    'to_formatted' => $weeklyChart->toFormatted,
                ],
                'tracks' => $tracks->map(function ($track): array {
                    return [
                        'name' => $track->name,
                        'artist' => $track->artist_name,
                        'album' => $track->album_name,
                        'playcount' => $track->pivot->playcount,
                        'url' => $track->url,
                    ];
                }),
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
