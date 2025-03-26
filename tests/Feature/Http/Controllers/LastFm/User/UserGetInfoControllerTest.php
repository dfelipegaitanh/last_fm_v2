<?php

declare(strict_types=1);

namespace Tests\Feature\LastFm\User;

use App\Contracts\Actions\LastFm\Users\GetUserInfoInterface;
use App\Models\LastFm\User as LastFmUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('returns unauthorized when user is not authenticated', function (): void {
    // Act
    $response = $this->getJson(route('last-fm.user_get_info'));

    // Assert
    $response->assertUnauthorized();
});

test('returns user info when user is authenticated and within rate limit', function (): void {
    // Arrange
    $user = User::factory()->create();
    $lastFmUser = LastFmUser::factory()->create([
        'user_id' => $user->id,
        'name' => 'test_user',
        'registered' => [
            '#text' => 1145933008,
            'unixtime' => '1145933008',
        ],
    ]);

    $this->mock(GetUserInfoInterface::class)
        ->shouldReceive('handle')
        ->once()
        ->with($user)
        ->andReturn($lastFmUser);

    // Act
    $response = $this->actingAs($user)
        ->getJson(route('last-fm.user_get_info'));

    // Assert
    $response->assertOk()
        ->assertJson([
            'name' => 'test_user',
            'join_date' => now()->createFromTimestamp(1145933008)->diffForHumans(['parts' => 4, 'join' => true]),
            'total_scrobbles' => 0,
        ]);
});
