<?php

namespace App\Actions\LastFmGlobalSongsStatistics;

use App\Models\LastFmGlobalSongsStatistics;
use Lorisleiva\Actions\Concerns\AsAction;

readonly class SaveGlobalSongsStatistics
{
    use AsAction;

    private array $userInfo;

    public function handle(array $userInfo): void
    {
        $this->userInfo = $userInfo;

        $attributes = $this->getAttributes();

        LastFmGlobalSongsStatistics::firstOrCreate(
            $attributes,
            collect($attributes)
                ->except('last_fm_user_id')
                ->all()
        );
    }

    protected function getAttributes(): array
    {
        return [
            'last_fm_user_id' => auth()->user()->lastFmUser->id,
            'playcount' => $this->userInfo['playcount'] ?? 0,
            'artist_count' => $this->userInfo['artist_count'] ?? 0,
            'track_count' => $this->userInfo['track_count'] ?? 0,
            'album_count' => $this->userInfo['album_count'] ?? 0,
        ];
    }
}
