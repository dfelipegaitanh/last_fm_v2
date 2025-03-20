<?php

declare(strict_types=1);

use App\Services\Api\LastFm\DTOs\AlbumDTO;

test('creates DTO from API response with minimum data', function () {
    // Arrange
    $data = [
        'title' => 'Album Title',
        'artist' => 'Artist Name',
        'url' => 'https://last.fm/album/1',
    ];

    // Act
    $dto = AlbumDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(AlbumDTO::class)
        ->title->toBe('Album Title')
        ->artist->toBe('Artist Name')
        ->url->toBe('https://last.fm/album/1')
        ->mbid->toBeNull();
});

test('creates DTO from API response with full data', function () {
    // Arrange
    $data = [
        'title' => 'Album Title',
        'artist' => [
            'name' => 'Artist Name',
        ],
        'url' => 'https://last.fm/album/1',
        'mbid' => '123-456',
    ];

    // Act
    $dto = AlbumDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(AlbumDTO::class)
        ->title->toBe('Album Title')
        ->artist->toBe('Artist Name')
        ->url->toBe('https://last.fm/album/1')
        ->mbid->toBe('123-456');
});

test('creates DTO from API response with artist #text field', function () {
    // Arrange
    $data = [
        'title' => 'Album Title',
        'artist' => [
            '#text' => 'Artist Name',
        ],
        'url' => 'https://last.fm/album/1',
    ];

    // Act
    $dto = AlbumDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(AlbumDTO::class)
        ->title->toBe('Album Title')
        ->artist->toBe('Artist Name')
        ->url->toBe('https://last.fm/album/1')
        ->mbid->toBeNull();
});
