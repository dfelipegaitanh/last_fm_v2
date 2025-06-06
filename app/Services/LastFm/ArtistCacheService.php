<?php

declare(strict_types=1);

namespace App\Services\LastFm;

use App\Actions\LastFm\Artists\FetchArtistInfo;
use App\Actions\LastFm\Artists\SaveArtist;
use App\DTOs\LastFm\ArtistInfoDTO;
use App\Models\LastFm\Artist;

class ArtistCacheService
{
    /**
     * @var array<string, Artist>
     */
    private array $cache = [];

    public function __construct(
        private readonly FetchArtistInfo $fetchArtistInfo,
        private readonly SaveArtist $saveArtist
    ) {}

    /**
     * Clear the artists cache
     */
    public function clearCache(): void
    {
        $this->cache = [];
    }

    /**
     * Gets an artist from cache or fetches it from the API and saves it
     *
     * @param  string  $username  The Last.fm username
     * @param  ArtistInfoDTO  $artistDTO  The artist information
     * @return Artist The saved artist model
     */
    public function getAndSaveArtist(string $username, ArtistInfoDTO $artistDTO): Artist
    {
        $cacheKey = $this->generateCacheKey($artistDTO->name);

        if (! isset($this->cache[$cacheKey])) {
            $artistInfo = $this->fetchArtistInfo->handle(
                username: $username,
                artist: $artistDTO
            );

            $artist = $this->saveArtist->handle($artistInfo);
            $this->cache[$cacheKey] = $artist;

            return $artist;
        }

        return $this->cache[$cacheKey];
    }

    /**
     * Generates a cache key for an artist
     *
     * @param  string  $artistName  The artist name
     * @return string The cache key
     */
    private function generateCacheKey(string $artistName): string
    {
        return md5(mb_strtolower($artistName));
    }
}
