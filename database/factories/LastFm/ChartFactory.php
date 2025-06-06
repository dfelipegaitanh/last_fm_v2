<?php

declare(strict_types=1);

namespace Database\Factories\LastFm;

use App\Enums\ChartType;
use App\Models\LastFm\Chart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChartFactory extends Factory
{
    protected $model = Chart::class;

    public function definition(): array
    {
        $from = $this->faker->unixTime();

        return [
            'from_timestamp' => $from,
            'to_timestamp' => $from + 604800, // Una semana en segundos
            'type' => ChartType::random(),
            'user_id' => User::factory(),
            'completed' => $this->faker->boolean(),
        ];
    }

    public function weekly(): self
    {
        return $this->state(fn (array $attributes): array => [
            'type' => ChartType::WEEKLY,
        ]);
    }
}
