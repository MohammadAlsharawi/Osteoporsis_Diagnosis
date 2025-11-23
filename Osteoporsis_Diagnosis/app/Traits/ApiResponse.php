<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse($data, $message): JsonResponse
    {
        return response()->json([
            'msg' => $message,
            'success' => true,
            'data' => $data,
        ]);
    }

    protected function errorResponse($message, $status = 400): JsonResponse
    {
        return response()->json([
            'msg' => $message,
            'success' => false,
            'data' => [],
        ], $status);
    }
}
