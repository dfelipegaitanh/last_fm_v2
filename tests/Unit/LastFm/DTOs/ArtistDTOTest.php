<?php

declare(strict_types=1);

use App\DTOs\LastFm\ArtistDTO;

test('creates artist dto from api response with minimum data', function (): void {
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

test('creates artist dto from api response with full data', function (): void {
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

test('creates artist dto from api response with #text field', function (): void {
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

test('creates artist dto from api response with missing url', function (): void {
    // Arrange
    $data = [
        'name' => 'Artist Name',
    ];

    // Act
    $dto = ArtistDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(ArtistDTO::class)
        ->name->toBe('Artist Name')
        ->url->toBe('')
        ->mbid->toBeNull();
});
