<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\{HttpException, UnauthorizedHttpException};
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService
{
    public function attemptAuth(array $credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                throw new UnauthorizedHttpException('', 'authentication failed');
            }
        } catch (JWTException $e) {
            throw new HttpException(500, "Can't create token.");
        }

        return $token;
    }

    public function getUser()
    {
        try {
            return JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            throw new HttpException(500, 'token error');
        }
    }
}
