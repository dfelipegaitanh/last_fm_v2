<?php

declare(strict_types=1);

use App\Actions\LastFm\FetchWeeklyChartList;
use App\Actions\LastFm\ProcessWeeklyTrackChart;
use App\DTOs\LastFm\WeeklyChartDTO;
use App\Models\LastFm\Chart;
use App\Models\User;
use Illuminate\Support\Collection;

beforeEach(function (): void {
    $this->user = User::factory()->create([
        'lastfm_user' => 'testuser',
    ]);
});

test('command imports weekly charts successfully', function (): void {
    // Mock the FetchWeeklyChartList action
    $fetchWeeklyChartList = Mockery::mock(FetchWeeklyChartList::class);
    $fetchWeeklyChartList->shouldReceive('handle')
        ->once()
        ->with('testuser')
        ->andReturn(Collection::make([
            new WeeklyChartDTO(1616976000, 1617580800),
            new WeeklyChartDTO(1617580800, 1618185600),
        ]));

    // Mock the ProcessWeeklyTrackChart action
    $processWeeklyTrackChart = Mockery::mock(ProcessWeeklyTrackChart::class);
    $processWeeklyTrackChart->shouldReceive('handle')
        ->twice()
        ->andReturn(Chart::factory()->create([
            'processed' => true,
        ]));

    // Replace the real actions with mocks
    $this->app->instance(FetchWeeklyChartList::class, $fetchWeeklyChartList);
    $this->app->instance(ProcessWeeklyTrackChart::class, $processWeeklyTrackChart);

    // Execute the command
    $this->artisan('lastfm:import-weekly-charts', [
        '--username' => 'testuser',
    ])
        ->expectsOutput('Importing weekly charts for Last.fm user: testuser')
        ->expectsOutput('Found 2 weekly charts')
        ->expectsOutput('Weekly charts import completed successfully')
        ->assertSuccessful();
});

test('command fails when username option is not provided', function (): void {
    // Execute the command without providing a username
    $this->artisan('lastfm:import-weekly-charts')
        ->expectsOutput('The Last.fm username option is required.')
        ->assertFailed();
});

test('command reprocesses charts when reprocess option is provided', function (): void {
    // Mock the FetchWeeklyChartList action
    $fetchWeeklyChartList = Mockery::mock(FetchWeeklyChartList::class);
    $fetchWeeklyChartList->shouldReceive('handle')
        ->once()
        ->with('testuser')
        ->andReturn(Collection::make([
            new WeeklyChartDTO(1616976000, 1617580800),
        ]));

    // Create a pre-processed chart
    $weeklyChart = Chart::factory()->create([
        'from_timestamp' => 1616976000,
        'to_timestamp' => 1617580800,
        'processed' => true,
    ]);

    // Mock the ProcessWeeklyTrackChart action
    $processWeeklyTrackChart = Mockery::mock(ProcessWeeklyTrackChart::class);
    $processWeeklyTrackChart->shouldReceive('handle')
        ->twice() // Called twice because of reprocessing
        ->andReturn($weeklyChart);

    // Replace the real actions with mocks
    $this->app->instance(FetchWeeklyChartList::class, $fetchWeeklyChartList);
    $this->app->instance(ProcessWeeklyTrackChart::class, $processWeeklyTrackChart);

    // Execute the command with reprocess option
    $this->artisan('lastfm:import-weekly-charts', [
        '--username' => 'testuser',
        '--reprocess' => true,
    ])
        ->expectsOutput('Importing weekly charts for Last.fm user: testuser')
        ->expectsOutput('Found 1 weekly charts')
        ->expectsOutput('Weekly charts import completed successfully')
        ->assertSuccessful();
});
