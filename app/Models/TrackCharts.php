<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\LastFm\Chart;
use App\Models\LastFm\Track;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackCharts extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'last_fm_track_chart';

    public function lastFmChart(): BelongsTo
    {
        return $this->belongsTo(Chart::class, 'last_fm_chart_id');
    }

    public function lastFmTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'last_fm_track_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
