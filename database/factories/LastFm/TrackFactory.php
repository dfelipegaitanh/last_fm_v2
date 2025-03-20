<?php

declare(strict_types=1);

namespace Database\Factories\LastFm;

use App\Models\LastFm\Album;
use App\Models\LastFm\Artist;
use App\Models\LastFm\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackFactory extends Factory
{
    protected $model = Track::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'artist_id' => Artist::factory(),
            'album_id' => Album::factory(),
            'mbid' => fake()->uuid(),
            'url' => fake()->url(),
        ];
    }
}
