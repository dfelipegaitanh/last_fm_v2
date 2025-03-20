<?php

declare(strict_types=1);

namespace Database\Factories\LastFm;

use App\Models\LastFm\User as LastFmUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = LastFmUser::class;

    public function definition(): array
    {
        $unixTime = fake()->unixTime();

        return [
            'user_id' => User::factory(),
            'name' => fake()->userName(),
            'subscriber' => fake()->boolean(),
            'country' => fake()->countryCode(),
            'url' => fake()->url(),
            'registered' => [
                '#text' => $unixTime,
                'unixtime' => (string) $unixTime,
            ],
        ];
    }
}
