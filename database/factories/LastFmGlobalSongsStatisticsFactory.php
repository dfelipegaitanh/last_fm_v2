<?php

namespace Database\Factories;

use App\Models\LastFmGlobalSongsStatistics;
use App\Models\LastFmUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LastFmGlobalSongsStatisticsFactory extends Factory
{
    protected $model = LastFmGlobalSongsStatistics::class;

    public function definition(): array
    {
        return [
            'playcount' => $this->faker->word(),
            'artist_count' => $this->faker->word(),
            'track_count' => $this->faker->word(),
            'album_count' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'last_fm_user_id' => LastFmUser::factory(),
        ];
    }
}
