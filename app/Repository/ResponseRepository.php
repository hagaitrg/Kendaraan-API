<?php 
namespace App\Repository;


interface ResponseInterface
{
    public function sendSuccess($code, $message, $data);
    public function sendError($code, $message, $data);
}

class ResponseRepository implements ResponseInterface
{
    public function sendSuccess($code, $message, $data)
    {
        return response()->json([
            'success' => true,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function sendError($code, $message, $data)
    {
        return response()->json([
            'success' => false,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }
}