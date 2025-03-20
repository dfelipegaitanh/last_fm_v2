<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model
{
    use HasFactory;

    protected $table = 'last_fm_artists';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'mbid',
        'url',
    ];

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    protected static function newFactory()
    {
        return \Database\Factories\LastFm\ArtistFactory::new();
    }
}
