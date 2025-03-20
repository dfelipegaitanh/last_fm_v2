<?php

declare(strict_types=1);

namespace Tests\Feature\LastFm\User;

use App\Contracts\Actions\LastFm\Statistics\GetGlobalSongsStatisticsInterface;
use App\Models\LastFm\User as LastFmUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;

uses(RefreshDatabase::class);

test('returns unauthorized when user is not authenticated', function (): void {
    // Act
    $response = $this->getJson(route('last-fm.user_get_statistics'));

    // Assert
    $response->assertUnauthorized();
});

test('returns statistics when user is authenticated', function (): void {
    // Arrange
    $user = User::factory()->create();
    $lastFmUser = LastFmUser::factory()->create([
        'user_id' => $user->id,
        'name' => 'test_user',
    ]);
    $statistics = new LengthAwarePaginator(
        [
            [
                'total_scrobbles' => 1000,
                'total_artists' => 100,
                'total_albums' => 200,
                'total_tracks' => 500,
            ],
        ],
        1,
        10,
        1
    );

    $this->mock(GetGlobalSongsStatisticsInterface::class)
        ->shouldReceive('handle')
        ->once()
        ->andReturn($statistics);

    // Act
    $response = $this->actingAs($user)
        ->getJson(route('last-fm.user_get_statistics'));

    // Assert
    $response->assertOk()
        ->assertJson([
            'data' => [
                [
                    'total_scrobbles' => 1000,
                    'total_artists' => 100,
                    'total_albums' => 200,
                    'total_tracks' => 500,
                ],
            ],
            'current_page' => 1,
            'per_page' => 10,
            'total' => 1,
        ]);
});
