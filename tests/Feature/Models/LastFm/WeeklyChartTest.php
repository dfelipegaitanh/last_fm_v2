<?php

declare(strict_types=1);

use App\Enums\ChartType;
use App\Models\LastFm\Track;
use App\Models\LastFm\WeeklyChart;
use App\Models\User;
use App\Services\DateService;

test('weekly chart has correct attributes', function (): void {
    // Arrange
    $from_timestamp = 1616976000;
    $to_timestamp = 1617580800;

    $weeklyChart = WeeklyChart::factory()->create([
        'from_timestamp' => $from_timestamp,
        'to_timestamp' => $to_timestamp,
        'type' => ChartType::WEEKLY,
        'processed' => true,
    ]);

    // Assert
    expect($weeklyChart)
        ->from_timestamp->toBe($from_timestamp)
        ->to_timestamp->toBe($to_timestamp)
        ->type->toBe(ChartType::WEEKLY)
        ->processed->toBeTrue();
});

test('weekly chart formats timestamps correctly', function (): void {
    // Arrange
    $form_timestamp = 1616976000;
    $to_timestamp = 1617580800;

    $weeklyChart = WeeklyChart::factory()->create([
        'from_timestamp' => $form_timestamp,
        'to_timestamp' => $to_timestamp,
    ]);

    // Act & Assert
    expect($weeklyChart->fromFormatted)
        ->toBe(DateService::timestampToDateTime($form_timestamp))
        ->and($weeklyChart->toFormatted)
        ->toBe(DateService::timestampToDateTime($to_timestamp));

});

test('weekly chart can have tracks', function (): void {
    // Arrange
    $user = User::factory()->create();
    $weeklyChart = WeeklyChart::factory()->create();
    $tracks = Track::factory()->count(3)->create();

    // Act
    foreach ($tracks as $track) {
        $weeklyChart->tracks()->attach($track, [
            'user_id' => $user->id,
            'playcount' => rand(1, 100),
        ]);
    }

    // Assert
    expect($weeklyChart->tracks)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Track::class);
});

test('weekly chart can filter tracks by user', function (): void {
    // Arrange
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $weeklyChart = WeeklyChart::factory()->create();
    $tracks = Track::factory()->count(5)->create();

    // Attach tracks to user1
    foreach ($tracks->take(3) as $track) {
        $weeklyChart->tracks()->attach($track, [
            'user_id' => $user1->id,
            'playcount' => rand(1, 100),
        ]);
    }

    // Attach tracks to user2
    foreach ($tracks->take(2) as $track) {
        $weeklyChart->tracks()->attach($track, [
            'user_id' => $user2->id,
            'playcount' => rand(1, 100),
        ]);
    }

    // Act & Assert
    expect($weeklyChart->tracksForUser($user1)->get())
        ->toHaveCount(3)
        ->and($weeklyChart->tracksForUser($user2)->get())
        ->toHaveCount(2);

});
