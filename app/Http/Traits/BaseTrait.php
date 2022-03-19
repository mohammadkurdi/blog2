<?php

namespace App\Http\Traits;

trait BaseTrait
{
    public function sendResponse($result, $message): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    public function sendError($error, $errorMessage=[], $code = 404): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'data' => $error,
        ];

        if (!empty($errorMessage)){
            $response['data'] = $errorMessage;
        }

        return response()->json($response,$code);
    }

}

