<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\AuthRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = $this->auth->attemptAuth($credentials);

        return response()->json(compact('token'));
    }
}
