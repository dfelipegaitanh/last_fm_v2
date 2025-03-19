<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    protected $table = 'last_fm_tracks';

    protected $fillable = [
        'name',
        'artist',
        'mbid',
        'url',
    ];

    public function globalSongsStatistics(): HasMany
    {
        return $this->hasMany(GlobalSongsStatistics::class);
    }
}
