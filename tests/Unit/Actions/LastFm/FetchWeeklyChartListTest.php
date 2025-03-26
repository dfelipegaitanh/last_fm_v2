<?php

declare(strict_types=1);

use App\Actions\LastFm\FetchWeeklyChartList;
use App\DTOs\LastFm\WeeklyChartDTO;
use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\Collection;

test('it fetches weekly chart list from Last.fm API', function (): void {
    // Arrange
    $username = 'testuser';
    $mockApi = mock(LastFmApi::class);

    $mockChartData = [
        ['from' => '1617580800', 'to' => '1618185600'],
        ['from' => '1616976000', 'to' => '1617580800'],
    ];

    $mockApi->shouldReceive('getWeeklyChartList')
        ->once()
        ->with($username)
        ->andReturn(collect($mockChartData));

    $action = new FetchWeeklyChartList($mockApi);

    // Act
    $result = $action->handle($username);

    // Assert
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(WeeklyChartDTO::class);

    expect($result->first())
        ->from->toBe(1617580800)
        ->to->toBe(1618185600);

    expect($result->last())
        ->from->toBe(1616976000)
        ->to->toBe(1617580800);
});

test('it returns empty collection when API returns no charts', function (): void {
    // Arrange
    $username = 'testuser';
    $mockApi = mock(LastFmApi::class);

    $mockApi->shouldReceive('getWeeklyChartList')
        ->once()
        ->with($username)
        ->andReturn(collect([]));

    $action = new FetchWeeklyChartList($mockApi);

    // Act
    $result = $action->handle($username);

    // Assert
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->toBeEmpty();
});
