<?php

namespace App\Services;
use App\Models\AccountActivated;
use Kawankoding\Fcm\Fcm;

use App\Dtos\Result;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Kreait\Laravel\Firebase\Facades\Firebase;
use NotificationChannels\Fcm\FcmMessage;

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
        try {
            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                throw new Exception('email or password not correct');
            }

            if ($user->status !== User::status_active) {
                throw new Exception('User account is not active');
            }
            if(isset($credentials["fcm"])){
                try {
                    $user->fcm()->create($credentials);
                } catch (QueryException $e) {
                    if ($e->errorInfo[1] != 1062) {
                        throw new \Exception($e->getMessage());
                    }
                }
                try {
                    $user->notify(new AccountActivated);

                }
                catch (\Exception $e){
                    dd($e->getMessage());
                }
                unset($credentials["fcm"]);}
            if (!Auth::attempt($credentials)) {
                throw new Exception('Email or password not correct');
            }

            if (!$user->hasRole(User::ROLE_CUSTOMER)) {
                throw new Exception('Unauthorized');
            }

            $token = $user->createToken('*');
            $data = [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];

            return $this->ok($data, 'Login successful');

        } catch (Exception $exception) {
             throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function socialLogin($attributes): Result
    {
        if (isset($attributes["name"])) {
            $user = $this->userService->getUserBy("name", $attributes["name"]);
            if (isset($attributes["user_id"])) {

                $attributes["remember_token"] = $attributes["user_id"];
            }
        } else if (isset($attributes["user_id"])) {
            $user = $this->userService->getUserBy("remember_token", $attributes["user_id"]);
            $attributes["remember_token"] = $attributes["user_id"];

        } else {
            throw new Exception("user not found");
        }
        return $this->extracted($user, $attributes);


    }

    /**
     * @throws Exception
     */
    public function phoneLogin($attributes): Result
    {
        $user = $this->userService->getUserBy("phone", $attributes["phone"]);
        return $this->extracted($user, $attributes);


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
     * @param $user
     * @param $attributes
     * @return Result
     * @throws Exception
     */
    public function extracted($user, $attributes): Result
    {
        if ($user instanceof User) {
            if($user->hasRole(User::ROLE_CUSTOMER)){
            $token = $user->createToken('*');
            $data = [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
            return $this->ok($data, 'login succeed');
        }else{
                throw new Exception("unauthorized");
            }
        }
        $attributes['status'] = User::status_active;
        if (!isset($attributes['password'])) {
            $attributes['password'] = "welcome1";
        }
        $attributes['registered'] = Carbon::parse(date('Y-m-d H:i:s'))->format('Y-m-d H:i:s');
        $user = $this->userService->store($attributes);
        // $user = $client->user()->get()->first();
        $user = $this->userService->ignoredFind($user->id);
        $token = $user->createToken('*');
        (new EmailService($this->userService))->sendWelcomeMail($user);
        $data = [
            'user' => $user->toLightWeightArray(),
            'token' => $token->plainTextToken,
        ];
        return $this->ok($data, 'clients:register:step1:done');
    }
    public function sendPushNotification()
    {
        $notification = Firebase::withTarget('token', 'device_registration_token')
            ->withNotification([
                'title' => 'Notification Title',
                'body' => 'Notification Body',
            ]);
    }
}
