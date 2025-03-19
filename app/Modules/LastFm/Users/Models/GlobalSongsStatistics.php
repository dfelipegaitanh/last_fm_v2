<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Models;

use App\Casts\NumberCast;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;

class GlobalSongsStatistics extends Model
{
    use HasFactory, KeepsDeletedModels;

    protected $fillable = [
        'last_fm_user_id',
        'track_id',
        'playcount',
        'artist_count',
        'track_count',
        'album_count',
    ];

    protected $table = 'last_fm_global_songs_statistics';

    public function lastFmUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function scopeBasicData($query)
    {
        return $query->select([
            'id',
            'track_id',
            'playcount',
            'artist_count',
            'track_count',
            'album_count',
            'created_at',
        ]);
    }

    protected function casts(): array
    {
        return [
            'playcount' => NumberCast::class,
            'artist_count' => NumberCast::class,
            'track_count' => NumberCast::class,
            'album_count' => NumberCast::class,
            'created_at' => 'datetime',
        ];
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => DateService::dateToDateTime($value),
        );
    }
}
