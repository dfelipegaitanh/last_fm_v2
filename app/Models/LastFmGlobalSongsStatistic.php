<?php

declare(strict_types=1);

namespace App\Models;

use App\Modules\LastFm\Users\Models\Track;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LastFmGlobalSongsStatistic extends Model
{
    protected $fillable = [
        'user_id',
        'track_id',
        'playcount',
        'artist_count',
        'track_count',
        'album_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }
}
