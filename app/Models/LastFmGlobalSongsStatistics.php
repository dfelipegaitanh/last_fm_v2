<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LastFmGlobalSongsStatistics extends Model
{
    protected $fillable = [
        'last_fm_user_id',
        'playcount',
        'artist_count',
        'track_count',
        'album_count',
    ];

    public function lastFmUser(): BelongsTo
    {
        return $this->belongsTo(LastFmUser::class);
    }
}
