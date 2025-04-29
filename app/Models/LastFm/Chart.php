<?php

declare(strict_types=1);

namespace App\Models\LastFm;

use App\Enums\ChartType;
use App\Models\User;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chart extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'from_timestamp',
        'to_timestamp',
        'type',
        'processed',
        'completed',
        'user_id',
    ];

    protected $table = 'last_fm_charts';

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

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'last_fm_track_chart', 'last_fm_chart_id', 'last_fm_track_id')
            ->withPivot(['user_id', 'playcount']);
    }

    public function tracksForUser(User $user): BelongsToMany
    {
        return $this->tracks()->wherePivot('user_id', $user->id);
    }

    // Para acceder a la relación con usuario específico

    //    public function chartTracks()
    //    {
    //        return $this->hasMany(ChartTrack::class, 'last_fm_chart_id');
    //    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'processed' => 'boolean',
            'completed' => 'boolean',
            'type' => ChartType::class,
        ];
    }
}
