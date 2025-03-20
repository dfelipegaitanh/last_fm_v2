<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\LastFm\Api\LastFmRateLimiter;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LastFmRateLimitMiddleware
{
    public function __construct(
        private readonly LastFmRateLimiter $rateLimiter
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->rateLimiter->tooManyAttempts()) {
            return response()->json([
                'error' => 'Too many requests',
                'available_in' => $this->rateLimiter->availableIn(),
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        $this->rateLimiter->hit();

        $response = $next($request);

        return $response->header('X-RateLimit-Remaining', (string) $this->rateLimiter->remaining());
    }
}
