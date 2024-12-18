<?php

namespace App\Models;

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
            'registered' => 'array',
        ];
    }
}
