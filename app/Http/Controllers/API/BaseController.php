<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Helpers\ResponseHelper;

class BaseController extends Controller
{
    public function sendSuccess($data = []){
        $response = [
            'status' => true ,
            'data' => $data,
        ];
        return response()->json($response , ResponseHelper::HTTP_OK);
    }

    public function sendError($errorMessages = [] , $code){
        $response = [
            'status' => false ,
        ];
        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }
        return response()->json($response , $code);

    }

}
