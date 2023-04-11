<?php

namespace App\Helper;

class Helper
{
    public static function responseData(
        $code,
        $message,
        $data = []
    ) {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
