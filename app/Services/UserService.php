<?php

namespace App\Services;

use App\DTOs\Result;
use App\Models\User;
use App\Models\UserFcm;
use Exception;
use Exception as ExceptionAlias;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['username', 'name', 'email', 'phone', 'password', 'role_id', 'status', 'language','tap_customer_id','cm_firebase_token',"remember_token","role"];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['username', 'name', 'email', 'phone','password', 'status', 'language','cm_firebase_token',"remember_token",'role'];

    /**
     * searchable field is a field which can be searched for from keyword parameter in search method
     */
    protected array $searchables = ['username', 'name'];

    /**
     *
     */
    protected array $with = [];

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query();
    }

    public function getUserBy(string $column, mixed $value)
    {
        return User::where($column, $value)->first();

    }

    /**
     * @throws ExceptionAlias
     */
    public function fcmSave(User $user, String $fcm): void
    {

        try {
            $user->fcm()->create(["fcm"=>$fcm]);

        } catch (QueryException $e) {
            if ($e->errorInfo[1] != 1062) {
                throw new \Exception($e->getMessage());
            }
            else{
                UserFcm::where('fcm', $fcm)->update(['user_id' => $user->id]);
            }
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    /**
     * @throws ExceptionAlias
     */
    public function login($role,array $credentials): \App\DTOs\Result
    {
        $user = $this->getUserBy('email', $credentials['email']);
        if (!$user instanceof User) {
            throw new Exception('Email or password not correct');
        }
        if ($user->status !== User::status_active) {
            throw new Exception('User account is not active');
        }

        if (isset($credentials["fcm"])) {
            $this->fcmSave($user, $credentials["fcm"]);
            unset($credentials["fcm"]);
        }

        if (!Auth::attempt($credentials)) {
            throw new Exception('Email or password not correct');
        }

        if (!$user->hasRole($role)) {
            throw new Exception('Unauthorized');
        }

        $token = $user->createToken('*');
        $data = ['user' => $user, 'token' => $token->plainTextToken,];

        return $this->ok($data, 'Login successful');
    }
    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {
        if (isset($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }
        if ($operation === 'store') {
            if (!isset($attributes['status'])) {
                $attributes['status'] = User::status_new;
            }
            if (!isset($attributes['language'])) {
                $attributes['language'] = 'en';
            }
        }
        return parent::prepare($operation, $attributes);
    }

    /**
     * @param $user
     * @param $attributes
     * @return Result
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function loginRegister($user, $attributes,$role): Result
    {

        if ($user instanceof User) {
            if (isset($credentials["fcm"])) {
                $this->fcmSave($user, $credentials["fcm"]);
                unset($credentials["fcm"]);
            }
            if($user->hasRole($role)){
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
        if (isset($credentials["fcm"])) {
            $this->fcmSave($user, $credentials["fcm"]);
            unset($credentials["fcm"]);
        }


        $attributes['status'] = User::status_active;
        if (!isset($attributes['password'])) {
            $attributes['password'] = "welcome1";
        }
        $attributes["role"]=$role;

        $attributes['registered'] = Carbon::parse(date('Y-m-d H:i:s'))->format('Y-m-d H:i:s');
        $user = $this->store($attributes);
        // $user = $client->user()->get()->first();
        $user = $this->ignoredFind($user->id);
        $token = $user->createToken('*');
        (new EmailService($this))->sendWelcomeMail($user);
        $data = [
            'user' => $user->toLightWeightArray(),
            'token' => $token->plainTextToken,
        ];
        return $this->ok($data, 'clients:register:step1:done');
    }
    /**
     * @throws ExceptionAlias
     */
    public function register($attributes): Result
    {

        $attributes['status'] = User::status_active;
        if(!isset($attributes['password'])){
            $attributes['password']="welcome1";
        }
        $attributes['registered'] = Carbon::parse(date('Y-m-d H:i:s'))->format('Y-m-d H:i:s');
        $user = $this->store($attributes);
        if ($user instanceof User) {
            // $user = $client->user()->get()->first();
            $user = $this->ignoredFind($user->id);
            $token = $user->createToken('*');
            (new EmailService($this))->sendWelcomeMail($user);
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

    /**
     * create a new user
     * @throws ExceptionAlias
     */
    public function store(array $attributes): Model
    {
        unset($attributes["fcm"]);
        // TODO: sites attribute value
        return parent::store($attributes);
    }    public function save($id,array $attributes): Result
{
        if(isset($attributes["password"])){
            $user=auth()->user();
            if($user instanceof User){
            if (Hash::check($attributes["current_password"], $user->password)) {
                $attributes["password"] = Hash::make($attributes["password"]);
                $user->update(["password" => $attributes["password"]]);
                unset($attributes["password"]);

            }
           else{
           throw  new \Exception("current password uncorrected",403);
           }
        }
        }
        return parent::save($id,$attributes);

    }



    /**
     * delete inner
     * @throws ExceptionAlias
     */
    public function delete( $id=0): Result
    {
        if(!$id){
            $id=auth()->id();
        }
        $record = $this->find($id);
        return parent::delete($id);
    }

    /**
     * activate user
     * @throws ExceptionAlias
     * @throws Throwable
     */
    public function activate(int $id): Result
    {
        $user = $this->find($id);
        if (!in_array($user->status, [User::status_unverified, User::status_suspended])) {
            throw new ExceptionAlias('users:activate:errors:bad');
        }
        $user->status = User::status_active;
        $user->saveOrFail();
        return $this->ok($id, 'users:activate:done');
    }

    /**
     * suspend user
     * @throws ExceptionAlias
     * @throws Throwable
     */
    public function suspend(int $id): Result
    {
        $user = $this->find($id);
        if (!in_array($user->status, [User::status_active])) {
            throw new ExceptionAlias('users:suspend:errors:base');
        }
        $user->status = User::status_suspended;
        $user->saveOrFail();
        return $this->ok($id, 'users:suspend:done');
    }

    /**
     *
     */
    public function ignoredFind( $id): User
    {
        $qb = $this->builder()->withoutGlobalScope('accessDB');

        if ($id == null) {
            throw new ExceptionAlias('records:find:errors:not_found');
        }
        else if (is_array($id)) {
            if (!count($id)) {
                throw new ExceptionAlias('records:find:errors:not_found');
            }
            foreach ($id as $k => $value) {
                $qb = $qb->where($k, '=', $value);
            }
        } else {
            $qb = $qb->where('id', '=', $id);
        }
        $qb = $qb->first();
        if (!$qb instanceof User) {
            throw new ExceptionAlias('records:find:errors:not_found');
        }
        return $qb;
    }
}
