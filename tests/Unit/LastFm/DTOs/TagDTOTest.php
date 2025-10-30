<?php

declare(strict_types=1);

use App\DTOs\LastFm\TagDTO;

test('creates tag dto from api response with minimum data', function (): void {
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

test('creates tag dto from api response with full data', function (): void {
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

test('creates tag dto from api response with missing fields', function (): void {
    // Arrange
    $data = [];

    // Act
    $dto = TagDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(TagDTO::class)
        ->name->toBe('')
        ->url->toBe('')
        ->count->toBeNull();
});
