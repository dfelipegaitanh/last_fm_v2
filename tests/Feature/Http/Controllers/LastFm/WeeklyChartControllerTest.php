<?php

declare(strict_types=1);

use App\Actions\LastFm\FetchWeeklyChartList;
use App\Actions\LastFm\ProcessWeeklyTrackChart;
use App\DTOs\LastFm\WeeklyChartDTO;
use App\Enums\ChartType;
use App\Http\Requests\LastFm\Charts\ListWeeklyChartsRequest;
use App\Http\Requests\LastFm\Charts\ShowWeeklyChartRequest;
use App\Http\Requests\LastFm\Charts\UserWeeklyChartsRequest;
use App\Models\LastFm\Chart;
use App\Models\LastFm\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('ListWeeklyChartsController returns weekly chart list for authenticated user', function (): void {
    // Arrange
    $user = User::factory()->create(['lastfm_user' => 'testuser']);

    $this->actingAs($user);

    // Mock the FormRequest authorize method to return true
    $this->partialMock(ListWeeklyChartsRequest::class, function ($mock): void {
        $mock->shouldReceive('authorize')->andReturn(true);
    });

    $mockAction = mock(FetchWeeklyChartList::class);

    $charts = collect([
        new WeeklyChartDTO(from: 1617580800, to: 1618185600),
        new WeeklyChartDTO(from: 1616976000, to: 1617580800),
    ]);

    $mockAction->shouldReceive('handle')
        ->once()
        ->with('testuser')
        ->andReturn($charts);

    $this->instance(FetchWeeklyChartList::class, $mockAction);

    // Act & Assert
    $response = $this->getJson('/last-fm/weekly-charts');

    $response->assertStatus(200)
        ->assertJsonCount(2)
        ->assertJsonPath('0.from', 1617580800)
        ->assertJsonPath('1.from', 1616976000);
});

test('ShowWeeklyChartController returns weekly chart tracks for authenticated user', function (): void {
    // Arrange
    $user = User::factory()->create(['lastfm_user' => 'testuser']);

    $this->actingAs($user);

    // Mock the FormRequest authorize method to return true
    $this->partialMock(ShowWeeklyChartRequest::class, function ($mock): void {
        $mock->shouldReceive('authorize')->andReturn(true);
        $mock->shouldReceive('validated')->andReturn(['from' => 1616976000, 'to' => 1617580800]);
    });

    $from = 1616976000;
    $to = 1617580800;

    $weeklyChart = Chart::factory()->create([
        'from_timestamp' => $from,
        'to_timestamp' => $to,
        'type' => ChartType::WEEKLY,
        'processed' => true,
    ]);

    $track1 = Track::factory()->create([
        'name' => 'Track 1',
        'artist_name' => 'Artist 1',
    ]);

    $track2 = Track::factory()->create([
        'name' => 'Track 2',
        'artist_name' => 'Artist 2',
    ]);

    $weeklyChart->tracks()->attach($track1, [
        'user_id' => $user->id,
        'playcount' => 10,
    ]);

    $weeklyChart->tracks()->attach($track2, [
        'user_id' => $user->id,
        'playcount' => 5,
    ]);

    $mockAction = mock(ProcessWeeklyTrackChart::class);

    $mockAction->shouldReceive('handle')
        ->once()
        ->with($user, $from, $to)
        ->andReturn($weeklyChart);

    $this->instance(ProcessWeeklyTrackChart::class, $mockAction);

    // Act & Assert
    $response = $this->getJson("/last-fm/weekly-charts/{$from}/{$to}");

    $response->assertStatus(200)
        ->assertJsonPath('chart.from', $from)
        ->assertJsonPath('chart.to', $to)
        ->assertJsonCount(2, 'tracks')
        ->assertJsonPath('tracks.0.name', 'Track 1')
        ->assertJsonPath('tracks.0.playcount', 10)
        ->assertJsonPath('tracks.1.name', 'Track 2')
        ->assertJsonPath('tracks.1.playcount', 5);
});

test('UserWeeklyChartsController returns weekly charts for specific user', function (): void {
    // Arrange
    $user = User::factory()->create(['lastfm_user' => 'testuser']);
    $targetUser = User::factory()->create(['lastfm_user' => 'targetuser']);

    $this->actingAs($user);

    // Mock the FormRequest authorize method to return true
    $this->partialMock(UserWeeklyChartsRequest::class, function ($mock): void {
        $mock->shouldReceive('authorize')->andReturn(true);
        $mock->shouldReceive('validated')->andReturn(['user' => 2]);
    });

    $weeklyChart1 = Chart::factory()->create([
        'from_timestamp' => 1617580800,
        'to_timestamp' => 1618185600,
        'type' => ChartType::WEEKLY,
        'processed' => true,
    ]);

    $weeklyChart2 = Chart::factory()->create([
        'from_timestamp' => 1616976000,
        'to_timestamp' => 1617580800,
        'type' => ChartType::WEEKLY,
        'processed' => true,
    ]);

    $track = Track::factory()->create();

    $weeklyChart1->tracks()->attach($track, [
        'user_id' => $targetUser->id,
        'playcount' => 10,
    ]);

    $weeklyChart2->tracks()->attach($track, [
        'user_id' => $targetUser->id,
        'playcount' => 5,
    ]);

    // Act & Assert
    $response = $this->getJson("/last-fm/users/{$targetUser->id}/weekly-charts");

    $response->assertStatus(200)
        ->assertJsonCount(2)
        ->assertJsonPath('0.chart.from', 1617580800)
        ->assertJsonPath('1.chart.from', 1616976000)
        ->assertJsonPath('0.track_count', 1)
        ->assertJsonPath('1.track_count', 1);
});

test('ListWeeklyChartsController returns error when user has no Last.fm username', function (): void {
    // Arrange
    $user = User::factory()->create(['lastfm_user' => null]);

    $this->actingAs($user);

    // Mock the FormRequest authorize method to return false
    $this->partialMock(ListWeeklyChartsRequest::class, function ($mock): void {
        $mock->shouldReceive('authorize')->andReturn(false);
    });

    // Act & Assert
    $response = $this->getJson('/last-fm/weekly-charts');

    $response->assertStatus(403);
});

test('ShowWeeklyChartController returns error when user has no Last.fm username', function (): void {
    // Arrange
    $user = User::factory()->create(['lastfm_user' => null]);

    $this->actingAs($user);

    // Mock the FormRequest authorize method to return false
    $this->partialMock(ShowWeeklyChartRequest::class, function ($mock): void {
        $mock->shouldReceive('authorize')->andReturn(false);
    });

    $from = 1616976000;
    $to = 1617580800;

    // Act & Assert
    $response = $this->getJson("/last-fm/weekly-charts/{$from}/{$to}");

    $response->assertStatus(403);
});
