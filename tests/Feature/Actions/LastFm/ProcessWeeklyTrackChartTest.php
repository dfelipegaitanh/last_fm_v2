<?php

declare(strict_types=1);

use App\Actions\LastFm\FetchWeeklyTrackChart;
use App\Actions\LastFm\ProcessWeeklyTrackChart;
use App\DTOs\LastFm\ArtistDTO;
use App\DTOs\LastFm\TrackInfoDTO;
use App\DTOs\LastFm\WeeklyTrackChartDTO;
use App\Enums\ChartType;
use App\Models\LastFm\Chart;
use App\Models\LastFm\Track;
use App\Models\User;

test('it creates a new weekly chart when none exists', function (): void {
    // Arrange
    $user = User::factory()->create(['lastfm_user' => 'testuser']);
    $from = 1616976000;
    $to = 1617580800;

    $mockFetchAction = mock(FetchWeeklyTrackChart::class);

    $trackInfo1 = new TrackInfoDTO(
        name: 'Track 1',
        mbid: 'track-mbid-1',
        url: 'https://last.fm/track/1',
        artist: new ArtistDTO(
            name: 'Artist 1',
            mbid: 'artist-mbid-1',
            url: 'https://last.fm/artist/1'
        ),
        album: null,
        loved: null,
        nowPlaying: false
    );

    $trackInfo2 = new TrackInfoDTO(
        name: 'Track 2',
        mbid: 'track-mbid-2',
        url: 'https://last.fm/track/2',
        artist: new ArtistDTO(
            name: 'Artist 2',
            mbid: 'artist-mbid-2',
            url: 'https://last.fm/artist/2'
        ),
        album: null,
        loved: null,
        nowPlaying: false
    );

    $mockTracks = collect([
        new WeeklyTrackChartDTO(track: $trackInfo1, playcount: 10),
        new WeeklyTrackChartDTO(track: $trackInfo2, playcount: 5),
    ]);

    $mockFetchAction->shouldReceive('handle')
        ->once()
        ->with($user->lastfm_username, $from, $to)
        ->andReturn($mockTracks);

    $action = new ProcessWeeklyTrackChart($mockFetchAction);

    // Act
    $result = $action->handle($user, $from, $to);

    // Assert
    expect($result)
        ->toBeInstanceOf(Chart::class)
        ->from_timestamp->toBe($from)
        ->to_timestamp->toBe($to)
        ->type->toBe(ChartType::WEEKLY)
        ->processed->toBeTrue();

    expect(Track::count())->toBe(2);

    expect($result->tracksForUser($user)->get())
        ->toHaveCount(2);

    $tracks = $result->tracksForUser($user)->get();

    expect($tracks->first()->pivot->playcount)->toBe(10);
    expect($tracks->last()->pivot->playcount)->toBe(5);
});

test('it reuses existing weekly chart', function (): void {
    // Arrange
    $user = User::factory()->create(['lastfm_user' => 'testuser']);
    $from = 1616976000;
    $to = 1617580800;

    // Create existing chart
    $existingChart = Chart::factory()->create([
        'from_timestamp' => $from,
        'to_timestamp' => $to,
        'type' => ChartType::WEEKLY,
        'processed' => false,
    ]);

    $mockFetchAction = mock(FetchWeeklyTrackChart::class);

    $trackInfo = new TrackInfoDTO(
        name: 'Track 1',
        mbid: 'track-mbid-1',
        url: 'https://last.fm/track/1',
        artist: new ArtistDTO(
            name: 'Artist 1',
            mbid: 'artist-mbid-1',
            url: 'https://last.fm/artist/1'
        ),
        album: null,
        loved: null,
        nowPlaying: false
    );

    $mockTracks = collect([
        new WeeklyTrackChartDTO(track: $trackInfo, playcount: 10),
    ]);

    $mockFetchAction->shouldReceive('handle')
        ->once()
        ->with($user->lastfm_username, $from, $to)
        ->andReturn($mockTracks);

    $action = new ProcessWeeklyTrackChart($mockFetchAction);

    // Act
    $result = $action->handle($user, $from, $to);

    // Assert
    expect($result->id)->toBe($existingChart->id);
    expect($result->processed)->toBeTrue();
    expect(Track::count())->toBe(1);
    expect($result->tracksForUser($user)->get())->toHaveCount(1);
});

test('it returns existing chart without processing if tracks already exist for user', function (): void {
    // Arrange
    $user = User::factory()->create(['lastfm_user' => 'testuser']);
    $from = 1616976000;
    $to = 1617580800;

    // Create existing chart
    $existingChart = Chart::factory()->create([
        'from_timestamp' => $from,
        'to_timestamp' => $to,
        'type' => ChartType::WEEKLY,
        'processed' => true,
    ]);

    // Create existing track
    $track = Track::factory()->create([
        'name' => 'Existing Track',
        'artist_name' => 'Existing Artist',
    ]);

    // Attach track to chart for this user
    $existingChart->tracks()->attach($track, [
        'user_id' => $user->id,
        'playcount' => 15,
    ]);

    $mockFetchAction = mock(FetchWeeklyTrackChart::class);

    // This should never be called
    $mockFetchAction->shouldNotReceive('handle');

    $action = new ProcessWeeklyTrackChart($mockFetchAction);

    // Act
    $result = $action->handle($user, $from, $to);

    // Assert
    expect($result->id)->toBe($existingChart->id);
    expect($result->processed)->toBeTrue();
    expect($result->tracksForUser($user)->get())->toHaveCount(1);
    expect($result->tracksForUser($user)->first()->name)->toBe('Existing Track');
});
