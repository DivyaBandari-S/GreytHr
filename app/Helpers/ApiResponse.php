<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ApiResponse
{
    /**
     * Success response.
     *
     * @param string $status
     * @param string|null $message
     * @param array|object|null $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function success(string $status = 'success', ?string $message = null, array|object|null $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json(
            [
                'status'  => $status,
                'message' => $message,
                'data'    => $data ?? new \stdClass(),
            ],
            $statusCode
        );
    }

    /**
     * Error response.
     *
     * @param string $status
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function error(string $status = 'error', ?string $message = null, int $statusCode = 500): JsonResponse
    {
        // Log the error message for debugging
        Log::error("API Error: {$message}", ['status' => $status, 'statusCode' => $statusCode]);

        return response()->json(
            [
                'status'  => $status,
                'message' => $message,
            ],
            $statusCode
        );
    }
}
