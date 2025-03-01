<?php

namespace App\Helpers;

class ApiResponse
{
    static function sendResponse($msg = null, $data = null, $status = null)
    {
        $response = array(
            'status' => $status,
            'message' => $msg,
            'data' => $data
        );

        return response()->json($response);
    }
}
