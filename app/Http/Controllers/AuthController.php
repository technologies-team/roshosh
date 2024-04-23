<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * Login
     *
     * @param LoginRequest $request
     * @return SuccessResponse
     * @throws Exception
     */
    public function login(LoginRequest $request): SuccessResponse
    {
        return $this->ok($this->service->login($request->all()));
    }

    /**
     * Me
     *
     * @return SuccessResponse
     * @throws Exception
     */
    public function me(): SuccessResponse
    {
        return $this->ok($this->service->me());
    }

    /**
     * Logout
     *
     * @return SuccessResponse
     * @throws Exception
     */
    public function logout(): SuccessResponse
    {
        return $this->ok($this->service->logout());
    }
}
