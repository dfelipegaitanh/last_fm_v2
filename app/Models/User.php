<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\LastFm\Track;
use App\Models\LastFm\User as LastFmUser;
use App\Models\LastFm\WeeklyChart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\DeletedModels\Models\Concerns\KeepsDeletedModels;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use KeepsDeletedModels;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'lastfm_user',
    ];

    public function weeklyChartTracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'last_fm_track_last_fm_weekly_chart', 'user_id', 'last_fm_track_id')
            ->withPivot(['last_fm_weekly_chart_id', 'playcount']);
    }

    public function weeklyCharts(): BelongsToMany
    {
        return $this->belongsToMany(WeeklyChart::class, 'last_fm_track_last_fm_weekly_chart', 'user_id', 'last_fm_weekly_chart_id')
            ->withPivot(['last_fm_track_id', 'playcount']);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function lastFmUser(): HasOne
    {
        return $this->hasOne(LastFmUser::class, 'user_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
