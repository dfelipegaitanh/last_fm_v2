<?php

declare(strict_types=1);

namespace App\Models\LastFm;

use App\Enums\ChartType;
use App\Models\User;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WeeklyChart extends Model
{
    use HasFactory;

    protected $table = 'last_fm_weekly_charts';

    public function fromFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => DateService::timestampToDateTime($this->from_timestamp)
        );
    }

    public function toFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => DateService::timestampToDateTime($this->to_timestamp)
        );
    }

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'last_fm_track_last_fm_weekly_chart', 'last_fm_weekly_chart_id', 'last_fm_track_id')
            ->withPivot(['user_id', 'playcount']);
    }

    // Para acceder a la relación con usuario específico
    public function tracksForUser(User $user): BelongsToMany
    {
        return $this->tracks()->wherePivot('user_id', $user->id);
    }

    protected function casts(): array
    {
        return [
            'processed' => 'boolean',
            'type' => ChartType::class,
        ];
    }
}
