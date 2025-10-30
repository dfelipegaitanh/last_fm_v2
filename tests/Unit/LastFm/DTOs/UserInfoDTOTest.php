<?php

declare(strict_types=1);

use App\DTOs\LastFm\UserInfoDTO;

test('creates user info dto from array with full data', function (): void {
    // Arrange
    $data = [
        'name' => 'test_user',
        'subscriber' => '1',
        'country' => 'Colombia',
        'url' => 'https://last.fm/user/test_user',
        'registered' => [
            'unixtime' => '1234567890',
            '#text' => '2024-01-01',
        ],
        'playcount' => '1000',
        'artist_count' => '100',
        'track_count' => '500',
        'album_count' => '50',
    ];

    // Act
    $dto = UserInfoDTO::fromArray($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(UserInfoDTO::class)
        ->name->toBe('test_user')
        ->subscriber->toBeTrue()
        ->country->toBe('Colombia')
        ->url->toBe('https://last.fm/user/test_user')
        ->registered->toBe([
            'unixtime' => '1234567890',
            '#text' => '2024-01-01',
        ])
        ->playcount->toBe(1000)
        ->artist_count->toBe(100)
        ->track_count->toBe(500)
        ->album_count->toBe(50);
});

test('creates user info dto from array with minimum data', function (): void {
    // Arrange
    $data = [
        'playcount' => '1000',
        'artist_count' => '100',
        'track_count' => '500',
        'album_count' => '50',
    ];

    // Act
    $dto = UserInfoDTO::fromArray($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(UserInfoDTO::class)
        ->name->toBe('')
        ->subscriber->toBeFalse()
        ->country->toBe('')
        ->url->toBe('')
        ->registered->toBe([])
        ->playcount->toBe(1000)
        ->artist_count->toBe(100)
        ->track_count->toBe(500)
        ->album_count->toBe(50);
});

test('converts user info dto to statistics array', function (): void {
    // Arrange
    $data = [
        'name' => 'test_user',
        'playcount' => '1000',
        'artist_count' => '100',
        'track_count' => '500',
        'album_count' => '50',
    ];

    $dto = UserInfoDTO::fromArray($data);

    // Act
    $statistics = $dto->toStatisticsArray();

    // Assert
    expect($statistics)
        ->toBe([
            'playcount' => 1000,
            'artist_count' => 100,
            'album_count' => 50,
            'track_count' => 500,
        ]);
});
