<?php

namespace App\Models;

use App\Services\DateService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LastFmUser extends Model
{
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

    public function lastFmGlobalSongsStatistics(): BelongsTo
    {
        return $this->belongsTo(LastFmGlobalSongsStatistics::class);
    }

    protected function casts(): array
    {
        return [
            'subscriber' => 'boolean',
        ];
    }

    protected function registered(): Attribute
    {
        return Attribute::make(
            get: fn($value) => DateService::timestampToDateTime(json_decode($value)->unixtime),
        );
    }

}
