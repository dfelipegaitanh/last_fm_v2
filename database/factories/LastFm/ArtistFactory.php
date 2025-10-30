<?php

declare(strict_types=1);

namespace Database\Factories\LastFm;

use App\Models\LastFm\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    protected $model = Artist::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'url' => fake()->url(),
        ];
    }
}
