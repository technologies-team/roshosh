<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginNumberRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SocialLoginRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\AuthService;
use App\Services\AuthVendorService;
use Exception;
use Illuminate\Http\Response;

class VendorController extends Controller
{
    private AuthVendorService $service;

    public function __construct(AuthVendorService $service)
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
     * @throws Exception
     */
    public function socialLogin(SocialLoginRequest $request): SuccessResponse
    {
        return $this->ok($this->service->socialLogin($request->all()));
    }

    /**
     * @throws Exception
     */
    public function phoneLogin(LoginNumberRequest $request): SuccessResponse
    {
        return $this->ok($this->service->phoneLogin($request->all()));
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

    /**
     * @throws Exception
     */
    public function delete($id ): SuccessResponse
    {
        return $this->ok($this->service->delete($id));
    }

    /**
     * @throws Exception
     */
    public function register(RegisterRequest $request): SuccessResponse
    {
        return $this->ok($this->service->register($request->all()));
    }
}
