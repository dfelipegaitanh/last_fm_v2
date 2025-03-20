<?php

use App\Models\User;
use App\Modules\LastFm\Users\Actions\Users\GetUserInfo;
use App\Modules\LastFm\Users\DTO\UserInfoDTO;
use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Modules\LastFm\Users\Models\User as LastFmUser;
use App\Services\Api\LastFm\DTO\AlbumDTO;
use App\Services\Api\LastFm\DTO\ArtistDTO;
use App\Services\Api\LastFm\DTO\TrackDTO;
use App\Services\Api\LastFm\DTO\TrackInfoDTO;
use App\Services\Api\LastFm\LastFmApi;
use App\Services\DateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'lastfm_user' => 'svigle'
    ]);

    $this->lastFmApi = mock(LastFmApi::class);

    // Mock getRecentTracks
    $recentTrack = new TrackDTO(
        name: 'Test Track',
        artist: 'Test Artist',
        url: 'https://last.fm/track/1',
        mbid: null,
        image: [],
        date: ['uts' => now()->timestamp],
        nowPlaying: false
    );

    $this->lastFmApi->expects('getRecentTracks')
        ->andReturn(collect([$recentTrack]));

    // Mock getTrackInfo
    $trackInfo = new TrackInfoDTO(
        name: 'Test Track',
        mbid: '',
        url: 'https://last.fm/track/1',
        artist: new ArtistDTO(
            name: 'Test Artist',
            url: 'https://last.fm/artist/1'
        ),
        album: new AlbumDTO(
            title: 'Test Album',
            artist: 'Test Artist',
            url: 'https://last.fm/album/1'
        ),
        loved: false
    );

    $this->lastFmApi->expects('getTrackInfo')
        ->andReturn($trackInfo);

    $this->app->instance(LastFmApi::class, $this->lastFmApi);
});

test('successfully syncs user info from LastFm', function () {
    // Arrange
    $timestamp = now()->timestamp;

    $userInfoDTO = new UserInfoDTO(
        name: 'svigle',
        subscriber: false,
        country: 'US',
        url: 'https://www.last.fm/user/svigle',
        registered: ['unixtime' => $timestamp],
        playcount: 1000,
        artist_count: 100,
        track_count: 500,
        album_count: 50
    );

    $this->lastFmApi
        ->expects('getUserInfo')
        ->with('svigle')
        ->andReturn($userInfoDTO);

    // Act
    $action = app()->make(GetUserInfo::class);
    $action->handle($this->user);

    // Assert
    expect(LastFmUser::count())->toBe(1);

    $lastFmUser = LastFmUser::first();
    expect($lastFmUser)
        ->name->toBe('svigle')
        ->subscriber->toBe(false)
        ->country->toBe('US')
        ->url->toBe('https://www.last.fm/user/svigle')
        ->registered->toBe(DateService::timestampToDateTime($timestamp));

    expect(GlobalSongsStatistics::count())->toBe(1);
});

test('updates existing LastFm user info', function () {
    // Arrange
    LastFmUser::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'oldusername'
    ]);

    $timestamp = now()->timestamp;
    $userInfoDTO = new UserInfoDTO(
        name: 'newusername',
        subscriber: true,
        country: 'UK',
        url: 'https://www.last.fm/user/newusername',
        registered: ['unixtime' => $timestamp],
        playcount: 2000,
        artist_count: 200,
        track_count: 1000,
        album_count: 100
    );

    $this->lastFmApi
        ->expects('getUserInfo')
        ->with('svigle')
        ->andReturn($userInfoDTO);

    // Act
    $action = app()->make(GetUserInfo::class);
    $action->handle($this->user);

    // Assert
    expect(LastFmUser::count())->toBe(1);

    $lastFmUser = LastFmUser::first();
    expect($lastFmUser)
        ->name->toBe('newusername')
        ->subscriber->toBe(true)
        ->country->toBe('UK')
        ->url->toBe('https://www.last.fm/user/newusername')
        ->registered->toBe(DateService::timestampToDateTime($timestamp));

    expect(GlobalSongsStatistics::count())->toBe(1);
});
