<?php

namespace App\Services;

use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService extends Service
{

    /**
     * login
     * @throws Exception
     */
    public function login(array $credentials): \App\Dtos\Result
    {
        try {
            $user = User::query()->where('email', '=', $credentials['email'])->get();

        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
        if (isset($user[0])) {
            $user = $user[0];
            if ($user instanceof User && $user->status == User::status_active) {
                if (Auth::attempt($credentials)) {

                    $token = $user->createToken('*');
                    $data = [
                        'user' => $user,
                        'token' => $token->plainTextToken,
                    ];
                    return $this->ok($data, 'login succeed');
                }
                throw new Exception('email or password not correct');
            }
        }
        throw new Exception('email or password not correct');
    }
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
}
