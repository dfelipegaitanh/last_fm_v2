<?php

namespace App\Models;

use App\Services\DateService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'uuid',
    ];

    protected $casts = [
        'registered' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statistics(): BelongsTo
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
            get: fn ($value) => DateService::timestampToDateTime(json_decode($value)->unixtime),
        );
    }
}
