<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Http\Responses\SuccessResponse;
use App\Models\BookService;
use App\Services\UserService;
use Exception;
use Throwable;

class BookController extends Controller
{
    private BookService $service;

    public function __construct(BookService  $service)
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
    public function confirm(int $id): SuccessResponse
    {
        return $this->ok($this->service->confirm($id));
    }

    public function cancel(int $id): SuccessResponse
    {
        return $this->ok($this->service->cancel($id));
    }

    public function reject(int $id): SuccessResponse
    {
        return $this->ok($this->service->reject($id));
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
