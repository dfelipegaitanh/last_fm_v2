<?php

declare(strict_types=1);

use App\Actions\LastFm\Statistics\GetGlobalSongsStatistics;
use App\Models\LastFm\Album;
use App\Models\LastFm\Artist;
use App\Models\LastFm\GlobalSongsStatistics;
use App\Models\LastFm\Track;
use App\Models\LastFm\User as LastFmUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create([
        'lastfm_user' => 'svigle',
    ]);

    $this->lastFmUser = LastFmUser::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'svigle',
    ]);

    $this->artist = Artist::factory()->create([
        'name' => 'Test Artist',
        'url' => 'https://last.fm/artist/1',
    ]);

    $this->album = Album::factory()->create([
        'title' => 'Test Album',
        'artist_id' => $this->artist->id,
        'url' => 'https://last.fm/album/1',
    ]);

    $this->track = Track::factory()->create([
        'name' => 'Test Track',
        'artist_id' => $this->artist->id,
        'album_id' => $this->album->id,
        'mbid' => fake()->uuid(),
        'url' => 'https://last.fm/track/1',
    ]);

    // Create multiple statistics to test pagination
    for ($i = 0; $i < 10; $i++) {
        GlobalSongsStatistics::factory()->create([
            'user_id' => $this->lastFmUser->id,
            'track_id' => $this->track->id,
            'playcount' => 1000 + $i,
            'artist_count' => 100 + $i,
            'track_count' => 500 + $i,
            'album_count' => 50 + $i,
        ]);
    }

    test()->actingAs($this->user);
});

test('successfully retrieves paginated global songs statistics', function (): void {
    // Act
    $action = app()->make(GetGlobalSongsStatistics::class);
    $result = $action->handle();

    // Assert
    expect($result)
        ->toBeInstanceOf(Illuminate\Pagination\LengthAwarePaginator::class)
        ->count()->toBe(GetGlobalSongsStatistics::PAGINATION)
        ->total()->toBe(10);

    $firstItem = $result->last();
    expect($firstItem)
        ->playcount->toBe(1009)
        ->artist_count->toBe(109)
        ->track_count->toBe(509)
        ->album_count->toBe(59)
        ->track->toBeInstanceOf(Track::class)
        ->track->artist->toBeInstanceOf(Artist::class)
        ->track->album->toBeInstanceOf(Album::class);
});

test('returns empty paginator when user has no statistics', function (): void {
    // Arrange
    GlobalSongsStatistics::query()->delete();

    // Act
    $action = app()->make(GetGlobalSongsStatistics::class);
    $result = $action->handle();

    // Assert
    expect($result)
        ->toBeInstanceOf(Illuminate\Pagination\LengthAwarePaginator::class)
        ->count()->toBe(0)
        ->total()->toBe(0);
});
