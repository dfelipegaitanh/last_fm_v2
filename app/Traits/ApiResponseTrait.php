<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponseTrait
{
    protected function error($message, $code): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }

    protected function notContent(): Response
    {
        return response()->noContent();
    }

    protected function ok($message, $data = []): JsonResponse
    {
        return $this->success($message, 200, $data);

    }

    protected function success($message, $code = 200, $data = []): JsonResponse
    {
        $response = [
            'message' => $message,
        ];
        if (! empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}
