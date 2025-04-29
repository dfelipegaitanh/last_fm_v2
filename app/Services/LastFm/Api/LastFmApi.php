<?php

declare(strict_types=1);

namespace App\Services\LastFm\Api;

use App\DTOs\LastFm\AlbumDTO;
use App\DTOs\LastFm\ArtistDTO;
use App\DTOs\LastFm\TagDTO;
use App\DTOs\LastFm\TrackDTO;
use App\DTOs\LastFm\TrackInfoDTO;
use App\DTOs\LastFm\UserInfoDTO;
use Illuminate\Support\Collection;
use RuntimeException;

class LastFmApi extends LastFmApiClient
{

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

    public function getTrackInfo(
        string $artist,
        string $track,
        ?string $username = null,
        ?string $mbid = null,
        bool $autocorrect = true,
    ): TrackInfoDTO {
        $params = [
            'track' => $track,
            'artist' => $artist,
            'autocorrect' => (int) $autocorrect,
        ];

        if ($username !== null) {
            $params['username'] = $username;
        }

        if ($mbid !== null) {
            $params['mbid'] = $mbid;
        }

        $response = $this->get('track.getInfo', $params);
        $trackData = $response->json('track');

        if (! $trackData) {
            throw new RuntimeException('Track not found or invalid response from Last.fm');
        }

        return TrackInfoDTO::fromApiResponse($trackData);
    }

    public function getUserInfo(string $username): UserInfoDTO
    {
        $response = $this->get('user.getInfo', [
            'user' => $username,
        ]);

        return UserInfoDTO::fromArray($response->json('user'));
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

    public function getWeeklyChartList(string $username): Collection
    {
        $response = $this->get('user.getWeeklyChartList', [
            'user' => $username,
        ]);

        return collect($response->json('weeklychartlist.chart'));
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
}
