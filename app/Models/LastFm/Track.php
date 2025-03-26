<?php

declare(strict_types=1);

namespace App\Models\LastFm;

use Database\Factories\LastFm\TrackFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    use HasFactory;

    protected $table = 'last_fm_tracks';

    protected $hidden = [
        'id',
        'artist_id',
        'album_id',
        'created_at',
        'updated_at',
    ];

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

    public function weeklyCharts(): BelongsToMany
    {
        return $this->belongsToMany(Chart::class, 'last_fm_track_chart', 'last_fm_track_id', 'last_fm_chart_id')
            ->withPivot(['user_id', 'playcount']);
    }

    public function weeklyChartsForUser(User $user): BelongsToMany
    {
        return $this->weeklyCharts()->wherePivot('user_id', $user->id);
    }

    protected static function newFactory(): TrackFactory
    {
        return TrackFactory::new();
    }
}
