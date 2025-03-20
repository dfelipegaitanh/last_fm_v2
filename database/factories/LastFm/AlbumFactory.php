<?php

declare(strict_types=1);

namespace Database\Factories\LastFm;

use App\Modules\LastFm\Users\Models\Album;
use App\Modules\LastFm\Users\Models\Artist;
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
