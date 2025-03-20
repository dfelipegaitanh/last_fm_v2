<?php

declare(strict_types=1);

use App\Services\Api\LastFm\DTOs\TagDTO;

test('creates DTO from API response with minimum data', function () {
    // Arrange
    $data = [
        'name' => 'Tag Name',
        'url' => 'https://last.fm/tag/1',
    ];

    // Act
    $dto = TagDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(TagDTO::class)
        ->name->toBe('Tag Name')
        ->url->toBe('https://last.fm/tag/1')
        ->count->toBeNull();
});

test('creates DTO from API response with full data', function () {
    // Arrange
    $data = [
        'name' => 'Tag Name',
        'url' => 'https://last.fm/tag/1',
        'count' => '100',
    ];

    // Act
    $dto = TagDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(TagDTO::class)
        ->name->toBe('Tag Name')
        ->url->toBe('https://last.fm/tag/1')
        ->count->toBe(100);
});
