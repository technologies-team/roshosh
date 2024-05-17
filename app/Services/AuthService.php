<?php

namespace App\Services;

use App\Dtos\Result;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService extends Service
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
    public function login(array $credentials): Result
    {
        $user = User::where('email', $credentials['email'])->firstOrFail();
        if (!$user instanceof User) {
            throw new Exception('Email or password not correct');
        }
        if ($user->status !== User::status_active) {
            throw new Exception('User account is not active');
        }

        if (isset($credentials["fcm"])) {
            $this->userService->fcmSave($user, $credentials["fcm"]);
            unset($credentials["fcm"]);
        }

        if (!Auth::attempt($credentials)) {
            throw new Exception('Email or password not correct');
        }

        if (!$user->hasRole(User::ROLE_CUSTOMER)) {
            throw new Exception('Unauthorized');
        }

        $token = $user->createToken('*');
        $data = ['user' => $user, 'token' => $token->plainTextToken,];

        return $this->ok($data, 'Login successful');
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
        return $this->userService->loginRegister($user, $attributes, User::ROLE_CUSTOMER);
    }

    /**
     * @throws Exception
     */
    public function phoneLogin($attributes): Result
    {
        $user = $this->userService->getUserBy("phone", $attributes["phone"]);
        return $this->userService->loginRegister($user, $attributes, User::ROLE_CUSTOMER);
    }

    /**
     * @throws Exception
     */
    public function me(): Result
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
    public function logout(): Result
    {
        $user = auth()->user();
        if ($user instanceof User) {
            $user->tokens()->delete();
            return $this->ok(true, 'done');
        }
        throw new Exception('unauthenticated');
    }

}
