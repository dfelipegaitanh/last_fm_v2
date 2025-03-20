<?php

declare(strict_types=1);

use App\Modules\LastFm\Users\DTOs\GlobalSongsStatisticsDTO;
use App\Modules\LastFm\Users\Models\Album;
use App\Modules\LastFm\Users\Models\Artist;
use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Modules\LastFm\Users\Models\Track;
use App\Modules\LastFm\Users\Models\User as LastFmUser;

test('creates DTO from model correctly', function () {
    // Arrange
    $artist = Artist::factory()->create();
    $album = Album::factory()->create(['artist_id' => $artist->id]);
    $track = Track::factory()->create([
        'artist_id' => $artist->id,
        'album_id' => $album->id,
    ]);

    $lastFmUser = LastFmUser::factory()->create();

    $model = GlobalSongsStatistics::factory()->create([
        'user_id' => $lastFmUser->id,
        'track_id' => $track->id,
        'playcount' => 100,
        'artist_count' => 10,
        'track_count' => 50,
        'album_count' => 5,
    ]);

    // Act
    $dto = GlobalSongsStatisticsDTO::fromModel($model);

    // Assert
    expect($dto)
        ->toBeInstanceOf(GlobalSongsStatisticsDTO::class)
        ->playcount->toBe(100)
        ->artist_count->toBe(10)
        ->track_count->toBe(50)
        ->album_count->toBe(5)
        ->track->toBeInstanceOf(Track::class)
        ->and($dto->track->artist)->toBeInstanceOf(Artist::class)
        ->and($dto->track->album)->toBeInstanceOf(Album::class);
});
