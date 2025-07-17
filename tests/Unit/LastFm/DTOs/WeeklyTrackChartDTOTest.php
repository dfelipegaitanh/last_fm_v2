<?php

declare(strict_types=1);

use App\DTOs\LastFm\AlbumDTO;
use App\DTOs\LastFm\ArtistDTO;
use App\DTOs\LastFm\TrackInfoDTO;
use App\DTOs\LastFm\WeeklyTrackChartDTO;

test('creates weekly track chart dto from api response with album', function (): void {
    // Arrange
    $data = [
        'name' => 'Track Name',
        'artist' => [
            'name' => 'Artist Name',
            'url' => 'https://last.fm/artist/1',
        ],
        'album' => [
            'title' => 'Album Title',
            'artist' => [
                'name' => 'Artist Name',
                'url' => 'https://last.fm/artist/1',
            ],
            'url' => 'https://last.fm/album/1',
            'mbid' => '456-789',
        ],
        'url' => 'https://last.fm/track/1',
        'mbid' => '123-456',
        'playcount' => '42',
    ];

    // Act
    $dto = WeeklyTrackChartDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(WeeklyTrackChartDTO::class)
        ->track->toBeInstanceOf(TrackInfoDTO::class)
        ->track->name->toBe('Track Name')
        ->track->artist->name->toBe('Artist Name')
        ->track->url->toBe('https://last.fm/track/1')
        ->track->mbid->toBe('123-456')
        ->track->album->toBeInstanceOf(AlbumDTO::class)
        ->track->album->title->toBe('Album Title')
        ->track->album->artist->toBeInstanceOf(ArtistDTO::class)
        ->track->album->artist->name->toBe('Artist Name')
        ->track->album->url->toBe('https://last.fm/album/1')
        ->track->album->mbid->toBe('456-789')
        ->playcount->toBe(42);
});

test('creates weekly track chart dto from api response without album', function (): void {
    // Arrange
    $data = [
        'name' => 'Track Name',
        'artist' => [
            'name' => 'Artist Name',
            'url' => 'https://last.fm/artist/1',
        ],
        'url' => 'https://last.fm/track/1',
        'mbid' => '123-456',
        'playcount' => '42',
    ];

    // Act
    $dto = WeeklyTrackChartDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(WeeklyTrackChartDTO::class)
        ->track->toBeInstanceOf(TrackInfoDTO::class)
        ->track->name->toBe('Track Name')
        ->track->artist->name->toBe('Artist Name')
        ->track->url->toBe('https://last.fm/track/1')
        ->track->mbid->toBe('123-456')
        ->track->album->toBeNull()
        ->playcount->toBe(42);
});

test('creates weekly track chart dto from api response with string playcount', function (): void {
    // Arrange
    $data = [
        'name' => 'Track Name',
        'artist' => [
            'name' => 'Artist Name',
            'url' => 'https://last.fm/artist/1',
        ],
        'url' => 'https://last.fm/track/1',
        'mbid' => '123-456',
        'playcount' => '42',
    ];

    // Act
    $dto = WeeklyTrackChartDTO::fromApiResponse($data);

    // Assert
    expect($dto)
        ->toBeInstanceOf(WeeklyTrackChartDTO::class)
        ->playcount->toBe(42);
});

test('creates weekly track chart dto directly with album', function (): void {
    // Arrange
    $artistDto = new ArtistDTO(
        name: 'Artist Name',
        url: 'https://last.fm/artist/1',
        mbid: '789-012'
    );

    $albumArtistDto = new ArtistDTO(
        name: 'Album Artist Name',
        url: 'https://last.fm/artist/1',
        mbid: '789-012'
    );

    $albumDto = new AlbumDTO(
        title: 'Album Title',
        artist: $albumArtistDto,
        url: 'https://last.fm/album/1',
        mbid: '456-789'
    );

    $trackInfoDto = new TrackInfoDTO(
        name: 'Track Name',
        mbid: '123-456',
        url: 'https://last.fm/track/1',
        artist: $artistDto,
        album: $albumDto,
        loved: null,
        nowPlaying: false
    );

    // Act
    $dto = new WeeklyTrackChartDTO(
        track: $trackInfoDto,
        playcount: 42,
    );

    // Assert
    expect($dto)
        ->toBeInstanceOf(WeeklyTrackChartDTO::class)
        ->track->toBe($trackInfoDto)
        ->track->album->toBe($albumDto)
        ->playcount->toBe(42);
});

test('creates weekly track chart dto directly without album', function (): void {
    // Arrange
    $artistDto = new ArtistDTO(
        name: 'Artist Name',
        url: 'https://last.fm/artist/1',
        mbid: '789-012'
    );

    $trackInfoDto = new TrackInfoDTO(
        name: 'Track Name',
        mbid: '123-456',
        url: 'https://last.fm/track/1',
        artist: $artistDto,
        album: null,
        loved: null,
        nowPlaying: false
    );

    // Act
    $dto = new WeeklyTrackChartDTO(
        track: $trackInfoDto,
        playcount: 42,
    );

    // Assert
    expect($dto)
        ->toBeInstanceOf(WeeklyTrackChartDTO::class)
        ->track->toBe($trackInfoDto)
        ->track->album->toBeNull()
        ->playcount->toBe(42);
});
