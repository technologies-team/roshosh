<?php

namespace App\Services;

use App\Dtos\Result;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthService extends Service
{
protected UserService $userService;
public function __construct(UserService $userService)
{
    $this->userService=$userService;

}

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

    /**
     * @throws Exception
     */
    public function socialLogin($attributes): Result
    {
        $user=$this->userService->getUserBy("name",$attributes["name"]);
        if($user instanceof User) {
            $token = $user->createToken('*');
            $data = [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
            return $this->ok($data, 'login succeed');
        }
        $attributes['status'] = User::status_active;
        if(!isset($attributes['password'])){
            $attributes['password']="welcome1";
        }
        $attributes['registered'] = Carbon::parse(date('Y-m-d H:i:s'))->format('Y-m-d H:i:s');
        $user = $this->userService->store($attributes);
        if ($user instanceof User) {
            // $user = $client->user()->get()->first();
            $user = $this->userService->ignoredFind($user->id);
            $token = $user->createToken('*');
            (new EmailService($this->userService))->sendWelcomeMail($user);
            $data = [
                'user' => $user->toLightWeightArray(),
                'token' => $token->plainTextToken,
            ];
            if ($user instanceof User) {
                return $this->ok($data, 'clients:register:step1:done');
            }
        }
        throw new \Exception('clients:register:step1:errors:failed');


    }
    public function phoneLogin($attributes): Result
    {
        $user=$this->userService->getUserBy("phone",$attributes["phone"]);
        if($user instanceof User) {
            $token = $user->createToken('*');
            $data = [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
            return $this->ok($data, 'login succeed');
        }
        $attributes['status'] = User::status_active;
        if(!isset($attributes['password'])){
            $attributes['password']="welcome1";
        }
        $attributes['registered'] = Carbon::parse(date('Y-m-d H:i:s'))->format('Y-m-d H:i:s');
        $user = $this->userService->store($attributes);
        if ($user instanceof User) {
            // $user = $client->user()->get()->first();
            $user = $this->userService->ignoredFind($user->id);
            $token = $user->createToken('*');
            (new EmailService($this->userService))->sendWelcomeMail($user);
            $data = [
                'user' => $user->toLightWeightArray(),
                'token' => $token->plainTextToken,
            ];
            if ($user instanceof User) {
                return $this->ok($data, 'clients:register:step1:done');
            }
        }
        throw new \Exception('clients:register:step1:errors:failed');


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
