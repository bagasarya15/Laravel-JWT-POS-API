<?php

namespace App\Traits;

use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait ResponseTrait
{
    public function wrapResponse(int $status, string $message, ?array $resource = []): JsonResponse
    {
        $result = [
            'status' => $status,
            'message' => $message
        ];

        if (is_array($resource) && isset($resource['data'])) {
            $result = array_merge($result, ['records' => $resource['data']]);

            if (isset($resource['links']) && isset($resource['meta'])) {
                $result = array_merge($result, ['pages' => ['links' => $resource['links'], 'meta' => $resource['meta']]]);
            }
        }

        return response()->json($result, $status);
    }
}
