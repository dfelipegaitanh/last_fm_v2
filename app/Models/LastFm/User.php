<?php

namespace App\Models\LastFm;

use App\Models\LastFm\GlobalSongsStatistics;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;

class User extends Model
{
    use HasFactory, HasUlids, KeepsDeletedModels;

    protected static function newFactory()
    {
        return \Database\Factories\LastFm\UserFactory::new();
    }

    protected $fillable = [
        'user_id',
        'name',
        'subscriber',
        'country',
        'url',
        'registered',
    ];

    protected $table = 'last_fm_users';

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(GlobalSongsStatistics::class, 'user_id');
    }

    public function latestStatistic(): HasOne
    {
        return $this->hasOne(GlobalSongsStatistics::class, 'user_id')->latestOfMany();
    }

    protected function casts(): array
    {
        return [
            'subscriber' => 'boolean',
            'registered' => 'json',
        ];
    }

    protected function registered(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => DateService::timestampToDateTime(json_decode($value)->unixtime),
        );
    }
}
