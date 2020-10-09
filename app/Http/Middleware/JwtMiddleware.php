<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => false, 'errors' => [__('Token is Invalid')] ], ResponseHelper::HTTP_UNAUTHORIZED);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => false, 'errors' => [__('Token is Expired')] ], ResponseHelper::HTTP_UNAUTHORIZED);
            } else {
                return response()->json(['status' => false, 'errors' => [__('Authorization Token not found')] ],ResponseHelper::HTTP_UNAUTHORIZED);
            }
        }
        return $next($request);
    }
}
