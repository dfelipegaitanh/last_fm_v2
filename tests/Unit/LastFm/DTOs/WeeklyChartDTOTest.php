<?php

declare(strict_types=1);

use App\DTOs\LastFm\WeeklyChartDTO;

test('creates weekly chart dto from api response', function (): void {
    // Arrange
    $data = [
        'from' => '1616976000',
        'to' => '1617580800',
    ];

    // Act
    $dto = WeeklyChartDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(WeeklyChartDTO::class)
        ->from->toBe(1616976000)
        ->to->toBe(1617580800);
});

test('creates weekly chart dto from api response with string values', function (): void {
    // Arrange
    $data = [
        'from' => '1616976000',
        'to' => '1617580800',
    ];

    // Act
    $dto = WeeklyChartDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(WeeklyChartDTO::class)
        ->from->toBe(1616976000)
        ->to->toBe(1617580800);
});

test('creates weekly chart dto directly', function (): void {
    // Act
    $dto = new WeeklyChartDTO(
        from: 1616976000,
        to: 1617580800,
    );

    // Assert
    expect($dto)
        ->toBeInstanceOf(WeeklyChartDTO::class)
        ->from->toBe(1616976000)
        ->to->toBe(1617580800);
});
