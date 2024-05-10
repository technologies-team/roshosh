<?php

namespace App\Services;

use App\Dtos\Result;
use App\Models\Coupon;
use App\Models\User;
use Exception as ExceptionAlias;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['username', 'name', 'email', 'phone', 'password', 'role_id', 'status', 'language','tap_customer_id','cm_firebase_token',"remember_token"];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['username', 'name', 'email', 'phone','password', 'status', 'language','cm_firebase_token',"remember_token"];

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
     */
    public function store(array $attributes): User
    {
        $record = parent::store($attributes);
        // TODO: sites attribute value
        if ($record instanceof User) {
        //    $record->sites()->attach([1]);
        }
        return $record;
    }    public function save($id,array $attributes): Result
{
        if(isset($attributes["password"])){
            $user=auth()->user();
            if (Hash::check($attributes["current_password"], $user->password)) {
                $attributes["password"] = Hash::make($attributes["password"]);
                $user->update(["password" => $attributes["password"]]);
                unset($attributes["password"]);

            }
           else{
           throw  new \Exception("current password uncorrected",403);
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
