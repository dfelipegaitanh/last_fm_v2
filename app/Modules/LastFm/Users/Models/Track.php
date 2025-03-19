<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    protected $table = 'last_fm_tracks';

    protected $fillable = [
        'name',
        'artist_id',
        'album_id',
        'mbid',
        'url',
    ];

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function globalSongsStatistics(): HasMany
    {
        return $this->hasMany(GlobalSongsStatistics::class);
    }
}
