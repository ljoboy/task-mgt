<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class APIController extends Controller
{

    /**
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @param bool $success
     * @return JsonResponse
     */
    private function response(
        mixed  $data,
        string $message,
        int    $code = 422,
        bool   $success = false
    ): JsonResponse
    {
        $response = [
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function responseError(
        string $message,
        array  $data = [],
        int    $code = 422
    ): JsonResponse
    {
        return $this->response($data, $message, $code);
    }

    /**
     * @param $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function responseSuccess(
        $data,
        string $message = 'Data retrieved successfully',
        int $code = 200
    ): JsonResponse
    {
        return $this->response($data, $message, $code, true);
    }
}
