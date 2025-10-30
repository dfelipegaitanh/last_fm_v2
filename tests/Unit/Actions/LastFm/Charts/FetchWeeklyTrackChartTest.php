<?php

declare(strict_types=1);

use App\Actions\LastFm\Charts\FetchWeeklyTrackChart;
use App\DTOs\LastFm\ArtistDTO;
use App\DTOs\LastFm\TrackDTO;
use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\Collection;
use Mockery\MockInterface;

test('filtra pistas con recuento de reproducciones menor o igual a 1', function (): void {
    // Arrange
    $mockLastFmApi = mock(LastFmApi::class, function (MockInterface $mock): void {
        $mockResponse = Collection::make([
            new TrackDTO(
                name: 'Canción Uno',
                artist: new ArtistDTO(name: 'Artista Uno', url: 'https://last.fm/artist/1', mbid: '1'),
                url: 'https://last.fm/track/1',
                mbid: '1',
                date: null,
                nowPlaying: false,
                playcount: 3
            ),
            new TrackDTO(
                name: 'Canción Dos',
                artist: new ArtistDTO(name: 'Artista Dos', url: 'https://last.fm/artist/2', mbid: '2'),
                url: 'https://last.fm/track/2',
                mbid: '2',
                date: null,
                nowPlaying: false,
                playcount: 1
            ),
            new TrackDTO(
                name: 'Canción Tres',
                artist: new ArtistDTO(name: 'Artista Tres', url: 'https://last.fm/artist/3', mbid: '3'),
                url: 'https://last.fm/track/3',
                mbid: '3',
                date: null,
                nowPlaying: false,
                playcount: 5
            ),
        ]);

        $mock->shouldReceive('getWeeklyTrackChart')
            ->once()
            ->with('testuser', 1623456789, 1623556789)
            ->andReturn($mockResponse);
    });

    $action = new FetchWeeklyTrackChart($mockLastFmApi);

    // Act
    $result = $action->handle('testuser', 1623456789);

    // Assert
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->sequence(
            fn ($track) => $track->toHaveProperty('name', 'Canción Uno')
                ->toHaveProperty('playcount', 3),
            fn ($track) => $track->toHaveProperty('name', 'Canción Tres')
                ->toHaveProperty('playcount', 5)
        );
});

test('devuelve colección vacía cuando no hay pistas con recuento mayor a 1', function (): void {
    // Arrange
    $mockLastFmApi = mock(LastFmApi::class, function (MockInterface $mock): void {
        $mockResponse = Collection::make([
            new TrackDTO(
                name: 'Canción Uno',
                artist: new ArtistDTO(name: 'Artista Uno', url: 'https://last.fm/artist/1', mbid: '1'),
                url: 'https://last.fm/track/1',
                mbid: '1',
                date: null,
                nowPlaying: false,
                playcount: 1
            ),
            new TrackDTO(
                name: 'Canción Dos',
                artist: new ArtistDTO(name: 'Artista Dos', url: 'https://last.fm/artist/2', mbid: '2'),
                url: 'https://last.fm/track/2',
                mbid: '2',
                date: null,
                nowPlaying: false,
                playcount: 0
            ),
        ]);

        $mock->shouldReceive('getWeeklyTrackChart')
            ->once()
            ->with('testuser', 1623456789, 1623556789)
            ->andReturn($mockResponse);
    });

    $action = new FetchWeeklyTrackChart($mockLastFmApi);

    // Act
    $result = $action->handle('testuser', 1623456789);

    // Assert
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->toBeEmpty();
});

test('devuelve todas las pistas cuando todas tienen recuento mayor a 1', function (): void {
    // Arrange
    $mockLastFmApi = mock(LastFmApi::class, function (MockInterface $mock): void {
        $mockResponse = Collection::make([
            new TrackDTO(
                name: 'Canción Uno',
                artist: new ArtistDTO(name: 'Artista Uno', url: 'https://last.fm/artist/1', mbid: '1'),
                url: 'https://last.fm/track/1',
                mbid: '1',
                date: null,
                nowPlaying: false,
                playcount: 2
            ),
            new TrackDTO(
                name: 'Canción Dos',
                artist: new ArtistDTO(name: 'Artista Dos', url: 'https://last.fm/artist/2', mbid: '2'),
                url: 'https://last.fm/track/2',
                mbid: '2',
                date: null,
                nowPlaying: false,
                playcount: 3
            ),
        ]);

        $mock->shouldReceive('getWeeklyTrackChart')
            ->once()
            ->with('testuser', 1623456789, 1623556789)
            ->andReturn($mockResponse);
    });

    $action = new FetchWeeklyTrackChart($mockLastFmApi);

    // Act
    $result = $action->handle('testuser', 1623456789);

    // Assert
    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2);
});

test('llama al servicio LastFmApi con los parámetros correctos', function (): void {
    // Arrange
    $username = 'testuser';
    $from = 1623456789;
    $to = 1623556789;

    $mockLastFmApi = mock(LastFmApi::class, function (MockInterface $mock) use ($username, $from, $to): void {
        $mockResponse = Collection::make([]);

        $mock->shouldReceive('getWeeklyTrackChart')
            ->once()
            ->with($username, $from, $to)
            ->andReturn($mockResponse);
    });

    $action = new FetchWeeklyTrackChart($mockLastFmApi);

    // Act
    $action->handle($username, $from);

    // Assert - La aserción está implícita en las expectativas del mock
});
