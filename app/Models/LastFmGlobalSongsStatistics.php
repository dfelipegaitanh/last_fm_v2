<?php

namespace App\Models;

use App\Casts\NumberCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;

class LastFmGlobalSongsStatistics extends Model
{
    use HasFactory, HasUuids, KeepsDeletedModels;

    protected $fillable = [
        'last_fm_user_id',
        'playcount',
        'artist_count',
        'track_count',
        'album_count',
        'uuid',
    ];

    protected $primaryKey = 'uuid';

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

    public function lastFmUser(): BelongsTo
    {
        return $this->belongsTo(LastFmUser::class);
    }

    public function scopeBasicData($query)
    {
        return $query->select(['playcount', 'artist_count', 'track_count', 'album_count', 'created_at']);
    }
}
