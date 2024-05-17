<?php

namespace App\Services;

use App\Dtos\Result;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthVendorService extends Service
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

    }

    /**
     * login
     * @throws Exception
     */
    public function login(array $credentials): \App\Dtos\Result
    {
        return $this->userService->login(User::ROLE_CUSTOMER,$credentials);
    }

    /**
     * @throws Exception
     */
    public function socialLogin($attributes): Result
    {
        if (isset($attributes["name"])) {
            $user = $this->userService->getUserBy("name", $attributes["name"]);

        } else if (isset($attributes["remember_token"])) {
            $user = $this->userService->getUserBy("remember_token", $attributes["remember_token"]);
        } else {
            throw new Exception("user not found");
        }
        return $this->userService->loginRegister($user, $attributes,User::ROLE_VENDOR);
    }

    /**
     * @throws Exception
     */
    public function phoneLogin($attributes): Result
    {
        $user = $this->userService->getUserBy("phone", $attributes["phone"]);
        return $this->userService->loginRegister($user, $attributes,User::ROLE_VENDOR);


    }

    /**
     * @throws Exception
     */
    public function me(): \App\Dtos\Result
    {
        $user = auth()->user();
        if ($user instanceof User) {
            return $this->ok($user, 'auth:me:done');
        }
        throw new Exception('unauthenticated');
    }

    /**
     * @throws Exception
     */
    public function logout(): \App\Dtos\Result
    {
        $user = auth()->user();
        if ($user instanceof User) {
            $user->tokens()->delete();
            return $this->ok(true, 'done');
        }
        throw new Exception('unauthenticated');
    }



    /**
     * @throws Exception
     */
    public function register($attributes): Result
    {
        $attributes["role"]=User::ROLE_VENDOR;
        return $this->userService->register($attributes);
    }

    /**
     * @throws Exception
     */
    public function delete($id): Result
    {
        return $this->userService->delete($id);
    }


}
