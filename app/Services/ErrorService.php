<?php

namespace App\Services;

class ErrorService
{
    public static function verboseError($option, $code, $status = null)
    {
        return response([
            'code'    => $code,
            'message' => 'Error on request',
            'data'    => [
                'status'  => (!$status) ? 404 : $status,
                'request' => $option,
            ],
        ]);
    }

    public static function bookingError($error)
    {
        return response([
            'status' => false,
            'error'  => $error,
        ]);
    }
}
