<?php

namespace Database\Factories\LastFm;

use App\Models\User;
use App\Modules\LastFm\Users\Models\User as LastFmUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = LastFmUser::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->userName(),
            'subscriber' => fake()->boolean(),
            'country' => fake()->countryCode(),
            'url' => fake()->url(),
            'registered' => fake()->unixTime(),
        ];
    }
}
