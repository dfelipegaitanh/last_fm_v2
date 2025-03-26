<?php

declare(strict_types=1);

namespace Tests\Feature\LastFm\User;

use App\Contracts\Actions\LastFm\Statistics\GetGlobalSongsStatisticsInterface;
use App\Models\LastFm\Album;
use App\Models\LastFm\Artist;
use App\Models\LastFm\GlobalSongsStatistics;
use App\Models\LastFm\Track;
use App\Models\LastFm\User as LastFmUser;
use App\Models\User;
use Exception;
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

test('returns statistics with track and artist information', function (): void {
    // Arrange
    $user = User::factory()->create();
    $lastFmUser = LastFmUser::factory()->create([
        'user_id' => $user->id,
        'name' => 'test_user',
    ]);
    
    // Crear datos de prueba con información de track y artist
    $statistics = new LengthAwarePaginator(
        [
            [
                'total_scrobbles' => 1000,
                'total_artists' => 100,
                'total_albums' => 200,
                'total_tracks' => 500,
                'track' => [
                    'name' => 'Test Track',
                    'url' => 'https://last.fm/music/test-track',
                    'artist' => [
                        'name' => 'Test Artist',
                        'url' => 'https://last.fm/music/test-artist',
                    ],
                    'album' => [
                        'name' => 'Test Album',
                        'url' => 'https://last.fm/music/test-album',
                    ],
                ],
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
                    'track' => [
                        'name' => 'Test Track',
                        'url' => 'https://last.fm/music/test-track',
                        'artist' => [
                            'name' => 'Test Artist',
                            'url' => 'https://last.fm/music/test-artist',
                        ],
                        'album' => [
                            'name' => 'Test Album',
                            'url' => 'https://last.fm/music/test-album',
                        ],
                    ],
                ],
            ],
        ]);
});

test('returns detailed statistics with multiple tracks and artists', function (): void {
    // Arrange
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
    
    $lastFmUser = LastFmUser::factory()->create([
        'user_id' => $user->id,
        'name' => 'test_lastfm_user',
    ]);
    
    // Crear artistas con nombres específicos
    $radiohead = Artist::factory()->create([
        'name' => 'Radiohead',
        'url' => 'https://last.fm/music/Radiohead',
        'mbid' => 'a74b1b7f-71a5-4011-9441-d0b5e4122711',
    ]);
    
    $arcadeFire = Artist::factory()->create([
        'name' => 'Arcade Fire',
        'url' => 'https://last.fm/music/Arcade+Fire',
        'mbid' => '52074ba6-e495-4ef3-9bb4-0703888a9f68',
    ]);
    
    $daftPunk = Artist::factory()->create([
        'name' => 'Daft Punk',
        'url' => 'https://last.fm/music/Daft+Punk',
        'mbid' => '056e4f3e-d505-4dad-8ec1-d04f521cbb56',
    ]);
    
    // Crear álbumes asociados a los artistas
    $okComputer = Album::factory()->create([
        'title' => 'OK Computer',
        'artist_id' => $radiohead->id,
        'url' => 'https://last.fm/music/Radiohead/OK+Computer',
        'mbid' => '0b6b4ba0-d36f-4257-8f04-3b216dd07a22',
    ]);
    
    $theSuburbs = Album::factory()->create([
        'title' => 'The Suburbs',
        'artist_id' => $arcadeFire->id,
        'url' => 'https://last.fm/music/Arcade+Fire/The+Suburbs',
        'mbid' => '3eb46f56-2f67-4471-8eee-05f7f9d6d08c',
    ]);
    
    $randomAccessMemories = Album::factory()->create([
        'title' => 'Random Access Memories',
        'artist_id' => $daftPunk->id,
        'url' => 'https://last.fm/music/Daft+Punk/Random+Access+Memories',
        'mbid' => '2f28e33f-83e2-4b87-b473-4e28f2d3838c',
    ]);
    
    // Crear tracks asociados a los artistas y álbumes
    $paranoidAndroid = Track::factory()->create([
        'name' => 'Paranoid Android',
        'artist_id' => $radiohead->id,
        'album_id' => $okComputer->id,
        'url' => 'https://last.fm/music/Radiohead/_/Paranoid+Android',
        'mbid' => '0a9a4e0f-e5eb-4254-8644-01f93f9e1f74',
    ]);
    
    $readyToStart = Track::factory()->create([
        'name' => 'Ready to Start',
        'artist_id' => $arcadeFire->id,
        'album_id' => $theSuburbs->id,
        'url' => 'https://last.fm/music/Arcade+Fire/_/Ready+to+Start',
        'mbid' => '0b6b4ba0-d36f-4257-8f04-3b216dd07a22',
    ]);
    
    $getLucky = Track::factory()->create([
        'name' => 'Get Lucky',
        'artist_id' => $daftPunk->id,
        'album_id' => $randomAccessMemories->id,
        'url' => 'https://last.fm/music/Daft+Punk/_/Get+Lucky',
        'mbid' => '2f28e33f-83e2-4b87-b473-4e28f2d3838c',
    ]);
    
    // Crear estadísticas para cada track
    GlobalSongsStatistics::factory()->create([
        'user_id' => $lastFmUser->id,
        'track_id' => $paranoidAndroid->id,
        'playcount' => 1250,
        'artist_count' => 3,
        'album_count' => 3,
        'track_count' => 3,
        'created_at' => now()->subDays(2),
    ]);
    
    GlobalSongsStatistics::factory()->create([
        'user_id' => $lastFmUser->id,
        'track_id' => $readyToStart->id,
        'playcount' => 980,
        'artist_count' => 3,
        'album_count' => 3,
        'track_count' => 3,
        'created_at' => now()->subDays(1),
    ]);
    
    GlobalSongsStatistics::factory()->create([
        'user_id' => $lastFmUser->id,
        'track_id' => $getLucky->id,
        'playcount' => 1500,
        'artist_count' => 3,
        'album_count' => 3,
        'track_count' => 3,
        'created_at' => now(),
    ]);
    
    // Act
    $response = $this->actingAs($user)
        ->getJson(route('last-fm.user_get_statistics'));
    
    // Assert
    $response->assertOk()
        ->assertJsonCount(3, 'data')
        ->assertJsonPath('per_page', 10)
        ->assertJsonPath('current_page', 1);
    
    // Verificar que los datos de las canciones estén presentes
    $responseData = $response->json('data');
    
    // Verificar que los tracks estén presentes en la respuesta
    $trackNames = collect($responseData)->pluck('track.name')->toArray();
    $this->assertContains('Paranoid Android', $trackNames);
    $this->assertContains('Ready to Start', $trackNames);
    $this->assertContains('Get Lucky', $trackNames);
    
    // Verificar que los artistas estén presentes en la respuesta
    $artistNames = collect($responseData)->pluck('track.artist.name')->toArray();
    $this->assertContains('Radiohead', $artistNames);
    $this->assertContains('Arcade Fire', $artistNames);
    $this->assertContains('Daft Punk', $artistNames);
    
    // Verificar que los álbumes estén presentes en la respuesta
    $albumNames = collect($responseData)->pluck('track.album.title')->toArray();
    $this->assertContains('OK Computer', $albumNames);
    $this->assertContains('The Suburbs', $albumNames);
    $this->assertContains('Random Access Memories', $albumNames);
});
