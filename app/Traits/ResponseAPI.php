<?php

namespace App\Traits;

trait ResponseAPI
{
    /**
     * Core of response
     *
     * @param $message
     * @param null $data
     * @param $statusCode
     * @param bool $isSuccess
     * @return \Illuminate\Http\JsonResponse
     */
    public function coreResponse($message, $data = null, $statusCode, $isSuccess = true)
    {
        // Check params
        if (!$message) return response()->json(['message' => 'Message is required'], 500);

        // Send artisan response
        if ($isSuccess) {
            return response()->json([
                'message' => $message,
                'error' => false,
                'code' => $statusCode,
                'data' => $data
            ], $statusCode);
        } else {
            return response()->json([
                'message' => $message,
                'error' => true,
                'code' => $statusCode,
            ], $statusCode);
        }
    }

    /**
     * Send artisan success response
     *
     * @param $message
     * @param $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $message = "OK", $statusCode = 200)
    {
        return $this->coreResponse($message, $data, $statusCode);
    }

    /**
     * Sand an error response
     *
     * @param $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $statusCode = 500)
    {
        return $this->coreResponse($message, null, $statusCode, false);
    }
}
