<?php

declare(strict_types=1);

namespace App\DTOs\LastFm;

use App\Models\LastFm\User as LastFmUser;
use App\Traits\CastsAttributesTrait;
use Spatie\LaravelData\Data;

class AuthenticatedUserDTO extends Data
{
    use CastsAttributesTrait;

    public function __construct(
        public readonly string $name,
        public readonly string $join_date,
        public readonly int $total_scrobbles,
    ) {}

    public static function fromModel(LastFmUser $lastFmUser): self
    {

        return new self(
            name: $lastFmUser->name ?? '',
            join_date: $lastFmUser->registered ?? '',
            total_scrobbles: self::toInt($lastFmUser->latestStatistic?->playcount) ?? 0,
        );
    }
}
