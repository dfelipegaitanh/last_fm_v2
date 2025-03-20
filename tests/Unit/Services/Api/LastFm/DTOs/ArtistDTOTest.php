<?php

declare(strict_types=1);

use App\Services\Api\LastFm\DTOs\ArtistDTO;

test('creates DTO from API response with minimum data', function () {
    // Arrange
    $data = [
        'name' => 'Artist Name',
        'url' => 'https://last.fm/artist/1',
    ];

    // Act
    $dto = ArtistDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(ArtistDTO::class)
        ->name->toBe('Artist Name')
        ->url->toBe('https://last.fm/artist/1')
        ->mbid->toBeNull();
});

test('creates DTO from API response with full data', function () {
    // Arrange
    $data = [
        'name' => 'Artist Name',
        'url' => 'https://last.fm/artist/1',
        'mbid' => '123-456',
    ];

    // Act
    $dto = ArtistDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(ArtistDTO::class)
        ->name->toBe('Artist Name')
        ->url->toBe('https://last.fm/artist/1')
        ->mbid->toBe('123-456');
});

test('creates DTO from API response with #text field', function () {
    // Arrange
    $data = [
        '#text' => 'Artist Name',
        'url' => 'https://last.fm/artist/1',
    ];

    // Act
    $dto = ArtistDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(ArtistDTO::class)
        ->name->toBe('Artist Name')
        ->url->toBe('https://last.fm/artist/1')
        ->mbid->toBeNull();
});
