<?php

declare(strict_types=1);

use App\DTOs\LastFm\AuthenticatedUserDTO;
use App\Models\LastFm\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('creates authenticated user dto from model with full data', function (): void {
    // Arrange
    $user = User::factory()->create([
        'name' => 'test_user',
        'registered' => [
            '#text' => 1145933008,
            'unixtime' => '1145933008',
        ],
    ]);

    $user->setRelation('latestStatistic', (object) [
        'playcount' => 1000,
    ]);

    // Act
    $dto = AuthenticatedUserDTO::fromModel($user);

    // Assert
    expect($dto)
        ->toBeInstanceOf(AuthenticatedUserDTO::class)
        ->name->toBe('test_user')
        ->join_date->toContain('ago')
        ->total_scrobbles->toBe(1000);
});

test('creates authenticated user dto from model with missing statistics', function (): void {
    // Arrange
    $user = User::factory()->create([
        'name' => 'test_user',
        'registered' => [
            '#text' => 1145933008,
            'unixtime' => '1145933008',
        ],
    ]);

    $user->setRelation('latestStatistic', null);

    // Act
    $dto = AuthenticatedUserDTO::fromModel($user);

    // Assert
    expect($dto)
        ->toBeInstanceOf(AuthenticatedUserDTO::class)
        ->name->toBe('test_user')
        ->join_date->toContain('ago')
        ->total_scrobbles->toBe(0);
});

test('creates authenticated user dto from model with missing data', function (): void {
    // Arrange
    $user = User::factory()->create([
        'name' => 'test_user',
        'registered' => [
            '#text' => 1145933008,
            'unixtime' => '1145933008',
        ],
    ]);

    $user->forceFill([
        'name' => '',
        'registered' => [
            '#text' => 0,
            'unixtime' => '',
        ],
    ])->save();

    $user->setRelation('latestStatistic', null);

    // Act
    $dto = AuthenticatedUserDTO::fromModel($user);

    // Assert
    expect($dto)
        ->toBeInstanceOf(AuthenticatedUserDTO::class)
        ->name->toBe('')
        ->join_date->toContain('ago')
        ->total_scrobbles->toBe(0);
});
