<?php

declare(strict_types=1);

namespace App\Models\LastFm;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $mbid
 * @property string $url
 * @property-read Collection|Track[] $tracks
 */
class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mbid',
        'url',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $table = 'last_fm_artists';

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    protected static function newFactory(): ArtistFactory
    {
        return \Database\Factories\LastFm\ArtistFactory::new();
    }
}
