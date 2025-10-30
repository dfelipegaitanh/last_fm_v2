<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Charts;

use App\Actions\LastFm\Tracks\FetchTrackInfo;
use App\Actions\LastFm\Tracks\SaveTrack;
use App\DTOs\LastFm\TrackInfoDTO;
use App\Models\LastFm\Chart;
use App\Models\User;
use App\Services\LastFm\ArtistCacheService;
use Illuminate\Support\Collection;

use function Laravel\Prompts\progress;

readonly class ProcessWeeklyTrackChartItems
{
    public function __construct(
        private ArtistCacheService $artistCacheService,
        private FetchTrackInfo $fetchTrackInfo,
        private SaveTrack $saveTrack,
        private SyncTrackWithWeeklyChart $syncTrackWithWeeklyChart
    ) {}

    public function handle(Chart $weeklyChart, Collection $tracks, User $user): void
    {
        $progress = progress(label: 'Processing tracks', steps: $tracks->count());
        $progress->start();

        $tracks->each(function (TrackInfoDTO $track) use ($weeklyChart, $user, $progress): void {
            $this->artistCacheService->getAndSaveArtist(
                $user->lastfm_user,
                $track->artist
            );

            $trackData = $this->fetchTrackInfo->handle(
                username: $user->lastfm_user,
                artist: $track->artist->name,
                track: $track->name
            );

            $progress->label = "Processing track {$trackData->name} by {$trackData->artist->name}";
            $progress->hint = "Track: {$trackData->name} by {$trackData->artist->name}";

            $trackLastFm = $this->saveTrack->handle($trackData);

            $this->syncTrackWithWeeklyChart->handle(
                $weeklyChart,
                $trackLastFm,
                $user,
                $track->playcount
            );

            // dump($trackData);

            $progress->advance();
        });

        $progress->finish();
    }
}
