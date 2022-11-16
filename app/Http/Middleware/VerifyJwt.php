<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\JwtController;
use Throwable;

class VerifyJwt
{

    /**
     * 驗證Jwt
     *
     * @param Request $request
     * @param Closure $next
     * @return void
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        try {
            $payload = JwtController::decodeJwtPayload($token);
            
            if ($payload->iat + JwtController::JWT_EXPIRE_TIME < time()) {
                return ApiController::sendApiResponse(null, 401, [], 'This token has been expired.');
            }
        } catch (Throwable $th) {
            if (empty($token)) {
                return ApiController::sendApiResponse(null, 403, [], 'Your token is empty.');
            }
            
            if (!JwtController::verifyToken($token)) {
                return ApiController::sendApiResponse(null, 401, [], 'This token is illegal.');
            }

            return ApiController::sendApiResponse(null, 401, [], 'Your token is error.');
        }
        return $next($request);
    }
}
