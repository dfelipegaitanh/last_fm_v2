<?php

namespace App\Models;

use App\Services\DateService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;

class LastFmUser extends Model
{
    use HasFactory, HasUlids, KeepsDeletedModels;

    protected $fillable = [
        'user_id',
        'name',
        'subscriber',
        'country',
        'url',
        'registered',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(LastFmGlobalSongsStatistics::class, 'last_fm_user_id');
    }

    public function latestStatistic(): HasOne
    {
        return $this->hasOne(LastFmGlobalSongsStatistics::class, 'last_fm_user_id')->latestOfMany();
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
            get: fn ($value) => DateService::timestampToDateTime(json_decode($value)->unixtime),
        );
    }
}
