<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Http\Responses\SuccessResponse;
use App\Services\UserService;
use Exception;
use Throwable;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService  $service)
    {
        $this->service = $service;
    }

    /**
     * activate
     *
     * @param int $id
     * @return SuccessResponse
     * @throws Throwable
     */
    public function activate(int $id): SuccessResponse
    {
        return $this->ok($this->service->activate($id));
    }

    /**
     * suspend
     *
     * @param int $id
     * @return SuccessResponse
     * @throws Throwable
     */
    public function suspend(int $id): SuccessResponse
    {
        return $this->ok($this->service->suspend($id));
    }

    /**
     * register
     *
     * @param RegisterRequest $request
     * @return SuccessResponse
     * @throws Exception
     */
    public function register(RegisterRequest $request): SuccessResponse
    {
        return $this->ok($this->service->register($request->all()));
    }

    /**
     * @throws Exception
     */
    public function update(UpdateUserRequest $request, int $id): SuccessResponse
    {
        return $this->ok($this->service->save($id, $request->all()));
    }    /**
     * @throws Exception
     */
    public function delete( ): SuccessResponse
    {
        return $this->ok($this->service->delete());
    }

}
