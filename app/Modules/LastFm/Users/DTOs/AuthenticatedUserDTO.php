<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\DTOs;

use App\Modules\LastFm\Users\Models\User as LastFmUser;
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
        $user = $lastFmUser->load('latestStatistic')->firstOrFail();

        return new self(
            name: $user->name ?? '',
            join_date: $user->registered ?? '',
            total_scrobbles: self::toInt($user->latestStatistic?->playcount) ?? 0,
        );
    }
}
