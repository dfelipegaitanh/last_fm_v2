<?php

declare(strict_types=1);

namespace App\Services\Api\LastFm;

use App\Services\Api\LastFm\DTO\AlbumDTO;
use App\Services\Api\LastFm\DTO\ArtistDTO;
use App\Services\Api\LastFm\DTO\TagDTO;
use App\Services\Api\LastFm\DTO\TrackDTO;
use App\Services\Api\LastFm\DTO\UserInfoDTO;
use Illuminate\Support\Collection;

class LastFmApi extends LastFmApiClient
{
    public function getUserInfo(string $username): UserInfoDTO
    {
        $response = $this->get('user.getInfo', [
            'user' => $username,
        ]);

        return UserInfoDTO::fromApiResponse($response->json('user'));
    }

    public function getRecentTracks(
        string $username,
        int $limit = 10,
        int $page = 1,
        ?int $from = null,
        ?int $to = null,
        bool $extended = false,
    ): Collection {
        $params = [
            'user' => $username,
            'limit' => $limit,
            'page' => $page,
        ];

        if ($from !== null) {
            $params['from'] = $from;
        }

        if ($to !== null) {
            $params['to'] = $to;
        }

        if ($extended) {
            $params['extended'] = 1;
        }

        $response = $this->get('user.getRecentTracks', $params);
        $tracks = $response->json('recenttracks.track');

        return collect($tracks)->map(fn (array $track): TrackDTO => TrackDTO::fromApiResponse($track));
    }

    public function getTopArtists(
        string $username,
        string $period = 'overall',
        int $limit = 50,
        int $page = 1,
    ): Collection {
        $response = $this->get('user.getTopArtists', [
            'user' => $username,
            'period' => $period,
            'limit' => $limit,
            'page' => $page,
        ]);

        $artists = $response->json('topartists.artist');

        return collect($artists)->map(fn (array $artist): ArtistDTO => ArtistDTO::fromApiResponse($artist));
    }

    public function getTopAlbums(
        string $username,
        string $period = 'overall',
        int $limit = 50,
        int $page = 1,
    ): Collection {
        $response = $this->get('user.getTopAlbums', [
            'user' => $username,
            'period' => $period,
            'limit' => $limit,
            'page' => $page,
        ]);

        $albums = $response->json('topalbums.album');

        return collect($albums)->map(fn (array $album): AlbumDTO => AlbumDTO::fromApiResponse($album));
    }

    public function getTopTracks(
        string $username,
        string $period = 'overall',
        int $limit = 50,
        int $page = 1,
    ): Collection {
        $response = $this->get('user.getTopTracks', [
            'user' => $username,
            'period' => $period,
            'limit' => $limit,
            'page' => $page,
        ]);

        $tracks = $response->json('toptracks.track');

        return collect($tracks)->map(fn (array $track): TrackDTO => TrackDTO::fromApiResponse($track));
    }

    public function getWeeklyArtistChart(
        string $username,
        ?int $from = null,
        ?int $to = null,
    ): Collection {
        $params = ['user' => $username];

        if ($from !== null) {
            $params['from'] = $from;
        }

        if ($to !== null) {
            $params['to'] = $to;
        }

        $response = $this->get('user.getWeeklyArtistChart', $params);
        $artists = $response->json('weeklyartistchart.artist');

        return collect($artists)->map(fn (array $artist): ArtistDTO => ArtistDTO::fromApiResponse($artist));
    }

    public function getWeeklyAlbumChart(
        string $username,
        ?int $from = null,
        ?int $to = null,
    ): Collection {
        $params = ['user' => $username];

        if ($from !== null) {
            $params['from'] = $from;
        }

        if ($to !== null) {
            $params['to'] = $to;
        }

        $response = $this->get('user.getWeeklyAlbumChart', $params);
        $albums = $response->json('weeklyalbumchart.album');

        return collect($albums)->map(fn (array $album): AlbumDTO => AlbumDTO::fromApiResponse($album));
    }

    public function getWeeklyTrackChart(
        string $username,
        ?int $from = null,
        ?int $to = null,
    ): Collection {
        $params = ['user' => $username];

        if ($from !== null) {
            $params['from'] = $from;
        }

        if ($to !== null) {
            $params['to'] = $to;
        }

        $response = $this->get('user.getWeeklyTrackChart', $params);
        $tracks = $response->json('weeklytrackchart.track');

        return collect($tracks)->map(fn (array $track): TrackDTO => TrackDTO::fromApiResponse($track));
    }

    public function getWeeklyChartList(string $username): Collection
    {
        $response = $this->get('user.getWeeklyChartList', [
            'user' => $username,
        ]);

        return collect($response->json('weeklychartlist.chart'));
    }

    public function getUserTags(
        string $username,
        int $limit = 50,
        int $page = 1,
    ): Collection {
        $response = $this->get('user.getTags', [
            'user' => $username,
            'limit' => $limit,
            'page' => $page,
        ]);

        $tags = $response->json('tags.tag');

        return collect($tags)->map(fn (array $tag): TagDTO => TagDTO::fromApiResponse($tag));
    }

    public function getPersonalTags(
        string $username,
        string $tag,
        string $taggingType,
        int $limit = 50,
        int $page = 1,
    ): array {
        $response = $this->get('user.getPersonalTags', [
            'user' => $username,
            'tag' => $tag,
            'taggingtype' => $taggingType,
            'limit' => $limit,
            'page' => $page,
        ]);

        return $response->json('taggings');
    }

    public function getLovedTracks(
        string $username,
        int $limit = 50,
        int $page = 1,
    ): Collection {
        $response = $this->get('user.getLovedTracks', [
            'user' => $username,
            'limit' => $limit,
            'page' => $page,
        ]);

        $tracks = $response->json('lovedtracks.track');

        return collect($tracks)->map(fn (array $track): TrackDTO => TrackDTO::fromApiResponse($track));
    }

    public function getFriends(
        string $username,
        int $limit = 50,
        int $page = 1,
        bool $recenttracks = false,
    ): Collection {
        $params = [
            'user' => $username,
            'limit' => $limit,
            'page' => $page,
        ];

        if ($recenttracks) {
            $params['recenttracks'] = 1;
        }

        $response = $this->get('user.getFriends', $params);

        return collect($response->json('friends.user'))
            ->map(fn (array $user): UserInfoDTO => UserInfoDTO::fromApiResponse($user));
    }
}
