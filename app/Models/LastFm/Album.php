<?php

declare(strict_types=1);

namespace App\Models\LastFm;

use App\Models\LastFm\Artist;
use App\Models\LastFm\Track;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;

    protected $table = 'last_fm_albums';

    protected $hidden = [
        'id',
        'artist_id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'artist_id',
        'mbid',
        'url',
    ];

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    protected static function newFactory()
    {
        return \Database\Factories\LastFm\AlbumFactory::new();
    }
}
