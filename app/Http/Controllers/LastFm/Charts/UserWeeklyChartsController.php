<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\Charts;

use App\Http\Requests\LastFm\Charts\UserWeeklyChartsRequest;
use App\Models\LastFm\WeeklyChart;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

readonly class UserWeeklyChartsController
{
    public function __invoke(UserWeeklyChartsRequest $request, User $user): JsonResponse
    {
        try {
            $charts = WeeklyChart::query()
                ->whereHas('tracks', function ($query) use ($user): void {
                    $query->wherePivot('user_id', $user->id);
                })
                ->orderBy('from_timestamp', 'desc')
                ->get();

            return response()->json($charts->map(function ($chart) use ($user): array {
                $tracks = $chart->tracksForUser($user)->get();

                return [
                    'chart' => [
                        'id' => $chart->id,
                        'from' => $chart->from_timestamp,
                        'to' => $chart->to_timestamp,
                        'from_formatted' => $chart->fromFormatted,
                        'to_formatted' => $chart->toFormatted,
                    ],
                    'track_count' => $tracks->count(),
                ];
            }));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
