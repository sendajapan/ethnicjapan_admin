<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class ApiResponseBuilder
{
    public static function success($message, $data = [], $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message, $errors = [], $code = 400): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
