<?php

declare(strict_types=1);

namespace App\Models\LastFm;

use App\Enums\ChartType;
use App\Models\User;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WeeklyChart extends Model
{
    protected $table = 'last_fm_weekly_charts';

    public function fromFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => DateService::formatTimestamp($this->from_timestamp)
        );
    }

    public function toFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => DateService::formatTimestamp($this->from_timestamp)
        );
    }

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'last_fm_track_last_fm_weekly_chart', 'last_fm_weekly_chart_id', 'last_fm_track_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'processed' => 'boolean',
            'type' => ChartType::class,
        ];
    }
}
