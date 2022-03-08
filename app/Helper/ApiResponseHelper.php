<?php
namespace App\Helper;

trait ApiResponseHelper
{
    public function onSuccess(int $statusCode, $message, $data)
    {
        return response()->json([
            'status'=>$statusCode,
            'message'=>$message,
            'data'=>$data,
        ], $statusCode);
    }

    public function onError(int $statusCode, $message)
    {
        return response()->json([
            'status'=>$statusCode,
            'message'=>$message,
        ], $statusCode);
    }
}