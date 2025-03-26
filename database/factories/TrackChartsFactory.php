<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\LastFm\Chart;
use App\Models\LastFm\Track;
use App\Models\TrackCharts;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackChartsFactory extends Factory
{
    protected $model = TrackCharts::class;

    public function definition(): array
    {
        return [
            'playcount' => $this->faker->randomNumber(),

            'last_fm_track_id' => Track::factory(),
            'last_fm_chart_id' => Chart::factory(),
            'user_id' => User::factory(),
        ];
    }
}
