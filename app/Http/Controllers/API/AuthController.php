<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseHelper;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), ResponseHelper::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = request()->only('email', 'password');

        try {
            if (!$token = Auth::attempt($credentials)) {
                return $this->sendError([__('Unauthorized')], ResponseHelper::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            // something went wrong
            return $this->sendError([__('Could Not Create Token')], ResponseHelper::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respondWithToken($token);
    }
    
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->sendSuccess([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
