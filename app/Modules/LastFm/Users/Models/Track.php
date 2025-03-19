<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $table = 'last_fm_tracks';

    protected $fillable = [
        'name',
        'artist',
        'url',
    ];
}
