<?php

declare(strict_types=1);

namespace Tests\Feature\LastFm\User;

use App\Contracts\Actions\LastFm\Users\GetUserInfoInterface;
use App\Models\LastFm\User as LastFmUser;
use App\Models\User;
use App\Services\LastFm\Api\LastFmRateLimiter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

uses(RefreshDatabase::class);

test('blocks requests when rate limit is exceeded', function () {
    // Arrange
    $user = User::factory()->create();
    $lastFmUser = LastFmUser::factory()->create([
        'user_id' => $user->id,
        'name' => 'test_user',
    ]);

    $this->mock(LastFmRateLimiter::class)
        ->shouldReceive('tooManyAttempts')
        ->andReturn(true)
        ->shouldReceive('availableIn')
        ->andReturn(30);

    // Act
    $response = $this->actingAs($user)
        ->getJson(route('last-fm.user_get_info'));

    // Assert
    $response->assertStatus(Response::HTTP_TOO_MANY_REQUESTS)
        ->assertJson([
            'error' => 'Too many requests',
            'available_in' => 30,
        ]);
});

test('includes rate limit headers in response', function () {
    // Arrange
    $user = User::factory()->create();
    LastFmUser::factory()->create([
        'user_id' => $user->id,
        'name' => 'test_user',
    ]);

    $this->mock(LastFmRateLimiter::class)
        ->shouldReceive('tooManyAttempts')
        ->andReturn(false)
        ->shouldReceive('hit')
        ->andReturn(1)
        ->shouldReceive('remaining')
        ->andReturn(4);

    $this->mock(GetUserInfoInterface::class)
        ->shouldReceive('handle')
        ->once()
        ->with($user);

    // Act
    $response = $this->actingAs($user)
        ->getJson(route('last-fm.user_get_info'));

    // Assert
    $response->assertOk()
        ->assertHeader('X-RateLimit-Remaining', '4');
});
