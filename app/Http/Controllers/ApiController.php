<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    public static function sendApiResponse($data, $status, array $headers = [], $message = '')
    {
        $response = [];
        if (!empty($data)) {
            $response['data'] = $data;
            $response['status'] = $status;
            $response['message'] = $message;
        } else {
            $response['status'] = $status;
            $response['message'] = $message;
        }
        return response()->json($response, $status, $headers);
    }
}
