<?php

namespace App\Helpers;

class ResponseFormatter
{
    protected static $response = [
        'status' => true,
        'message' => null,
        'errors' => null,
        'data' => null,
    ];

    public static function success($data = null, $message = null, $code = 200, $status = true, $errors = null)
    {
        self::$response['status'] = $status;
        self::$response['message'] = $message;
        self::$response['errors'] = $errors;
        self::$response['data'] = $data;

        return response()->json(self::$response, $code);
    }

    public static function error($message = null, $errors = null, $code = 404, $status = false)
    {
        self::$response['status'] = $status;
        self::$response['message'] = $message;
        self::$response['errors'] = $errors;
        self::$response['data'] = null;

        return response()->json(self::$response, $code);
    }
}
