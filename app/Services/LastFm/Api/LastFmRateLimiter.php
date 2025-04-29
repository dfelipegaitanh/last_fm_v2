<?php

declare(strict_types=1);

namespace App\Services\LastFm\Api;

use Illuminate\Cache\RateLimiter;

class LastFmRateLimiter
{
    private const int DECAY_MINUTES = 1;

    private const string KEY = 'lastfm-api';

    private const int MAX_ATTEMPTS = 5;

    private RateLimiter $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
        $this->limiter->for(self::KEY, fn (): null => null);
    }

    public function availableIn(): int
    {
        return $this->limiter->availableIn($this->key());
    }

    public function hit(): int
    {
        return $this->limiter->hit(
            $this->key(),
            self::DECAY_MINUTES * 60
        );
    }

    public function remaining(): int
    {
        return $this->limiter->remaining(
            $this->key(),
            self::MAX_ATTEMPTS
        );
    }

    public function tooManyAttempts(): bool
    {
        return $this->limiter->tooManyAttempts(
            $this->key(),
            self::MAX_ATTEMPTS
        );
    }

    private function key(): string
    {
        return sprintf(
            '%s:%s',
            self::KEY,
            auth()->id() ?? 'guest'
        );
    }
}
