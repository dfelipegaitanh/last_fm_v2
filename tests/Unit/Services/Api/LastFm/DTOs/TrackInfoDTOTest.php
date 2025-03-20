<?php

declare(strict_types=1);

use App\Services\Api\LastFm\DTOs\TrackInfoDTO;

test('creates DTO from API response with minimum data', function () {
    // Arrange
    $data = [
        'name' => 'Track Name',
        'url' => 'https://last.fm/track/1',
        'artist' => [
            'name' => 'Artist Name',
            'url' => 'https://last.fm/artist/1',
        ],
    ];

    // Act
    $dto = TrackInfoDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(TrackInfoDTO::class)
        ->name->toBe('Track Name')
        ->mbid->toBe('')
        ->url->toBe('https://last.fm/track/1')
        ->artist->name->toBe('Artist Name')
        ->album->toBeNull()
        ->loved->toBeNull();
});

test('creates DTO from API response with full data', function () {
    // Arrange
    $data = [
        'name' => 'Track Name',
        'mbid' => '123-456',
        'url' => 'https://last.fm/track/1',
        'artist' => [
            'name' => 'Artist Name',
            'url' => 'https://last.fm/artist/1',
            'mbid' => '789-012',
        ],
        'album' => [
            'title' => 'Album Title',
            'artist' => 'Artist Name',
            'url' => 'https://last.fm/album/1',
            'mbid' => '345-678',
        ],
        'userloved' => '1',
    ];

    // Act
    $dto = TrackInfoDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(TrackInfoDTO::class)
        ->name->toBe('Track Name')
        ->mbid->toBe('123-456')
        ->url->toBe('https://last.fm/track/1')
        ->artist->name->toBe('Artist Name')
        ->artist->mbid->toBe('789-012')
        ->album->title->toBe('Album Title')
        ->album->mbid->toBe('345-678')
        ->loved->toBeTrue();
});
