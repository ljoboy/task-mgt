<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
        int    $code,
        bool   $success
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
        string $message = 'A problem occurred! Please try again!',
        int    $code = Response::HTTP_UNPROCESSABLE_ENTITY,
        array  $data = []
    ): JsonResponse
    {
        return $this->response(data: $data, message: $message, code: $code, success: false);
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
        int $code = Response::HTTP_OK
    ): JsonResponse
    {
        return $this->response(data: $data, message: $message, code: $code, success: true);
    }
}
