<?php

declare(strict_types=1);

namespace App\Models\LastFm;

use App\Enums\ChartType;
use App\Models\TrackCharts;
use App\Models\User;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chart extends Model
{
    use HasFactory;


    protected $table = 'last_fm_charts';

    public function from(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->from_timestamp
        );
    }

    public function fromFormatted(): Attribute
    {
        return Attribute::make(
            get: fn (): string => DateService::timestampToDateTime($this->from_timestamp)
        );
    }

    public function fromFormattedDate(): Attribute
    {
        return Attribute::make(
            get: fn (): string => DateService::timestampToFormattedDate($this->from_timestamp)
        );
    }

    /**
     * Marca el chart como completo.
     *
     * @return $this
     */
    public function markAsComplete(): self
    {
        $this->update([
            'completed' => true,
        ]);

        return $this;
    }

    /**
     * Marca el chart como incompleto.
     *
     * @return $this
     */
    public function markAsIncomplete(): self
    {
        $this->update([
            'completed' => false,
        ]);

        return $this;
    }

    public function to(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->to_timestamp
        );
    }

    public function toFormatted(): Attribute
    {
        return Attribute::make(
            get: fn (): string => DateService::timestampToDateTime($this->to_timestamp)
        );
    }

    public function toFormattedDate(): Attribute
    {
        return Attribute::make(
            get: fn (): string => DateService::timestampToFormattedDate($this->to_timestamp)
        );
    }

    public function trackCharts(): HasMany
    {
        return $this->hasMany(TrackCharts::class, 'last_fm_chart_id');
    }

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(
            Track::class,
            'last_fm_track_chart',
            'last_fm_chart_id',
            'last_fm_track_id'
        )->withPivot(['user_id', 'playcount']);
    }

    public function tracksForUser(User $user): BelongsToMany
    {
        return $this->tracks()->wherePivot('user_id', $user->id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
            'type' => ChartType::class,
        ];
    }
}
