<?php

declare(strict_types=1);

use App\DTOs\LastFm\AlbumDTO;

test('creates album dto from api response with minimum data', function (): void {
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

test('creates album dto from api response with full data', function (): void {
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

test('creates album dto from api response with artist #text field', function (): void {
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
        ->url->toBe('https://last.fm/album/1');
});

test('creates album dto from api response with missing fields', function (): void {
    // Arrange
    $data = [];

    // Act
    $dto = AlbumDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(AlbumDTO::class)
        ->title->toBe('')
        ->artist->toBe('')
        ->url->toBe('')
        ->mbid->toBeNull();
});
