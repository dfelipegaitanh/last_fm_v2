<?php

declare(strict_types=1);

namespace Database\Factories\LastFm;

use App\Modules\LastFm\Users\Models\Album;
use App\Modules\LastFm\Users\Models\Artist;
use App\Modules\LastFm\Users\Models\Track;
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
