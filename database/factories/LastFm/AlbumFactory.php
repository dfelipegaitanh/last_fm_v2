<?php

declare(strict_types=1);

namespace Database\Factories\LastFm;

use App\Models\LastFm\Album;
use App\Models\LastFm\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumFactory extends Factory
{
    protected $model = Album::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'artist_id' => Artist::factory(),
            'url' => fake()->url(),
        ];
    }
}
