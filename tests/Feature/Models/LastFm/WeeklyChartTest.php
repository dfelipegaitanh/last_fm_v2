<?php

declare(strict_types=1);

use App\Enums\ChartType;
use App\Models\LastFm\Chart;
use App\Models\LastFm\Track;
use App\Models\User;
use App\Services\DateService;

test('chart has correct attributes', function (): void {
    // Arrange
    $from_timestamp = 1616976000;
    $to_timestamp = 1617580800;

    $Chart = Chart::factory()->create([
        'from_timestamp' => $from_timestamp,
        'to_timestamp' => $to_timestamp,
        'type' => ChartType::WEEKLY,
        'processed' => true,
    ]);

    // Assert
    expect($Chart)
        ->from_timestamp->toBe($from_timestamp)
        ->to_timestamp->toBe($to_timestamp)
        ->type->toBe(ChartType::WEEKLY)
        ->processed->toBeTrue();
});

test('chart formats timestamps correctly', function (): void {
    // Arrange
    $form_timestamp = 1616976000;
    $to_timestamp = 1617580800;

    $Chart = Chart::factory()->create([
        'from_timestamp' => $form_timestamp,
        'to_timestamp' => $to_timestamp,
    ]);

    // Act & Assert
    expect($Chart->fromFormatted)
        ->toBe(DateService::timestampToDateTime($form_timestamp))
        ->and($Chart->toFormatted)
        ->toBe(DateService::timestampToDateTime($to_timestamp));

});

test('chart can have tracks', function (): void {
    // Arrange
    $user = User::factory()->create();
    $Chart = Chart::factory()->create();
    $tracks = Track::factory()->count(3)->create();

    // Act
    foreach ($tracks as $track) {
        $Chart->tracks()->attach($track, [
            'user_id' => $user->id,
            'playcount' => rand(1, 100),
        ]);
    }

    // Assert
    expect($Chart->tracks)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Track::class);
});

test('chart can filter tracks by user', function (): void {
    // Arrange
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $Chart = Chart::factory()->create();
    $tracks = Track::factory()->count(5)->create();

    // Attach tracks to user1
    foreach ($tracks->take(3) as $track) {
        $Chart->tracks()->attach($track, [
            'user_id' => $user1->id,
            'playcount' => rand(1, 100),
        ]);
    }

    // Attach tracks to user2
    foreach ($tracks->take(2) as $track) {
        $Chart->tracks()->attach($track, [
            'user_id' => $user2->id,
            'playcount' => rand(1, 100),
        ]);
    }

    // Act & Assert
    expect($Chart->tracksForUser($user1)->get())
        ->toHaveCount(3)
        ->and($Chart->tracksForUser($user2)->get())
        ->toHaveCount(2);

});
