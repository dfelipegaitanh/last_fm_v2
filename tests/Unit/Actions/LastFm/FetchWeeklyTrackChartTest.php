<?php

declare(strict_types=1);

use App\Actions\LastFm\FetchWeeklyTrackChart;
use App\DTOs\LastFm\ArtistDTO;
use App\DTOs\LastFm\TrackInfoDTO;
use App\DTOs\LastFm\WeeklyTrackChartDTO;
use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\Collection;

test('it fetches weekly track chart from Last.fm API', function (): void {
    // Arrange
    $username = 'testuser';
    $from = 1616976000;
    $to = 1617580800;

    $mockApi = mock(LastFmApi::class);

    $mockTrackData = [
        [
            'name' => 'Track 1',
            'mbid' => 'track-mbid-1',
            'artist' => ['name' => 'Artist 1', 'mbid' => 'artist-mbid-1', 'url' => 'https://last.fm/artist/1'],
            'url' => 'https://last.fm/track/1',
            'playcount' => '10',
        ],
        [
            'name' => 'Track 2',
            'mbid' => 'track-mbid-2',
            'artist' => ['name' => 'Artist 2', 'mbid' => 'artist-mbid-2', 'url' => 'https://last.fm/artist/2'],
            'url' => 'https://last.fm/track/2',
            'playcount' => '5',
        ],
    ];

    $mockApi->shouldReceive('getWeeklyTrackChart')
        ->once()
        ->with($username, $from, $to)
        ->andReturn(collect($mockTrackData));

    $action = new FetchWeeklyTrackChart($mockApi);

    // Act
    $result = $action->handle($username, $from, $to);

    // Assert
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(WeeklyTrackChartDTO::class);

    expect($result->first()->track)
        ->toBeInstanceOf(TrackInfoDTO::class)
        ->name->toBe('Track 1')
        ->mbid->toBe('track-mbid-1')
        ->url->toBe('https://last.fm/track/1');

    expect($result->first()->track->artist)
        ->toBeInstanceOf(ArtistDTO::class)
        ->name->toBe('Artist 1');

    expect($result->first()->playcount)->toBe(10);
    expect($result->last()->playcount)->toBe(5);
});

test('it returns empty collection when API returns no tracks', function (): void {
    // Arrange
    $username = 'testuser';
    $from = 1616976000;
    $to = 1617580800;

    $mockApi = mock(LastFmApi::class);

    $mockApi->shouldReceive('getWeeklyTrackChart')
        ->once()
        ->with($username, $from, $to)
        ->andReturn(collect([]));

    $action = new FetchWeeklyTrackChart($mockApi);

    // Act
    $result = $action->handle($username, $from, $to);

    // Assert
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->toBeEmpty();
});
