<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\LastFm\GlobalSongsStatistics;
use App\Models\LastFm\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LastFmGlobalSongsStatisticsFactory extends Factory
{
    protected $model = GlobalSongsStatistics::class;

    public function definition(): array
    {
        return [
            'playcount' => $this->faker->word(),
            'artist_count' => $this->faker->word(),
            'track_count' => $this->faker->word(),
            'album_count' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
