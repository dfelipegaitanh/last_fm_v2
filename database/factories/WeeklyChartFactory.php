<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ChartType;
use App\Models\LastFm\WeeklyChart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeeklyChartFactory extends Factory
{
    protected $model = WeeklyChart::class;

    public function definition(): array
    {
        return [
            'from' => $this->faker->dateTime(),
            'to' => $this->faker->dateTime(),
            'type' => ChartType::random(),
            'user_id' => User::factory(),
        ];
    }
}
