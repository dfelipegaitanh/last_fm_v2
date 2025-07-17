<?php

declare(strict_types=1);

namespace App\Models\LastFm;

use App\Services\DateService;
use Database\Factories\LastFm\GlobalSongsStatisticsFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;

class GlobalSongsStatistics extends Model
{
    use HasFactory, KeepsDeletedModels;

    protected $fillable = [
        'user_id',
        'track_id',
        'playcount',
        'artist_count',
        'track_count',
        'album_count',
    ];

    protected $hidden = [
        'id',
        'track_id',
        'user_id',
        //        'created_at',
        'updated_at',
    ];

    protected $table = 'last_fm_global_songs_statistics';

    public function lastFmUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    protected static function newFactory()
    {
        return GlobalSongsStatisticsFactory::new();
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => DateService::dateToDateTime($value, 1),
        );
    }
}
