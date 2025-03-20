<?php

declare(strict_types=1);

use App\Services\Api\LastFm\DTOs\TrackDTO;

test('creates DTO from API response with minimum data', function () {
    // Arrange
    $data = [
        'name' => 'Track Name',
        'artist' => ['#text' => 'Artist Name'],
        'url' => 'https://last.fm/track/1',
        'image' => [],
    ];

    // Act
    $dto = TrackDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(TrackDTO::class)
        ->name->toBe('Track Name')
        ->artist->toBe('Artist Name')
        ->url->toBe('https://last.fm/track/1')
        ->mbid->toBeNull()
        ->image->toBe([])
        ->date->toBeNull()
        ->nowPlaying->toBeFalse();
});

test('creates DTO from API response with full data', function () {
    // Arrange
    $data = [
        'name' => 'Track Name',
        'artist' => ['#text' => 'Artist Name'],
        'url' => 'https://last.fm/track/1',
        'mbid' => '123-456',
        'image' => [
            ['#text' => 'image1.jpg', 'size' => 'small'],
            ['#text' => 'image2.jpg', 'size' => 'medium'],
        ],
        'date' => [
            'uts' => '1234567890',
            '#text' => '01 Jan 2020',
        ],
        '@attr' => [
            'nowplaying' => 'true',
        ],
    ];

    // Act
    $dto = TrackDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(TrackDTO::class)
        ->name->toBe('Track Name')
        ->artist->toBe('Artist Name')
        ->url->toBe('https://last.fm/track/1')
        ->mbid->toBe('123-456')
        ->image->toBe([
            ['#text' => 'image1.jpg', 'size' => 'small'],
            ['#text' => 'image2.jpg', 'size' => 'medium'],
        ])
        ->date->toBe([
            'uts' => '1234567890',
            '#text' => '01 Jan 2020',
        ])
        ->nowPlaying->toBeTrue();
});

test('creates DTO from API response with string artist', function () {
    // Arrange
    $data = [
        'name' => 'Track Name',
        'artist' => 'Artist Name',
        'url' => 'https://last.fm/track/1',
        'image' => [],
    ];

    // Act
    $dto = TrackDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(TrackDTO::class)
        ->artist->toBe('Artist Name');
});
