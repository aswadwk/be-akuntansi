<?php

namespace App\Helpers;

class ResponseFormatter
{
    public static function success($data, string $message, $code=200)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'errors' => null,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }

    public static function error(string $message = null, $errors, $code=404)
    {
        $response = [
            'status' => false,
            'message' => $message,
            'errors' => $errors,
            'data' => null
        ];

        return response()->json($response, $code);
    }
}
