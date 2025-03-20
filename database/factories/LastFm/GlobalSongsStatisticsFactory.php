<?php

declare(strict_types=1);

namespace Database\Factories\LastFm;

use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Modules\LastFm\Users\Models\Track;
use App\Modules\LastFm\Users\Models\User as LastFmUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class GlobalSongsStatisticsFactory extends Factory
{
    protected $model = GlobalSongsStatistics::class;

    public function definition(): array
    {
        return [
            'user_id' => LastFmUser::factory(),
            'track_id' => Track::factory(),
            'playcount' => fake()->numberBetween(1, 1000),
            'artist_count' => fake()->numberBetween(1, 100),
            'track_count' => fake()->numberBetween(1, 500),
            'album_count' => fake()->numberBetween(1, 50),
        ];
    }
}
