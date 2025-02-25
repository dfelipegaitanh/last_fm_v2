<?php

namespace Database\Factories;

use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Modules\LastFm\Users\Models\User;
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
            'uuid' => $this->faker->uuid(),

            'last_fm_user_id' => User::factory(),
        ];
    }
}
