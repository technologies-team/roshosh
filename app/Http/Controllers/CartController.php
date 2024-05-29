<?php

namespace App\Http\Controllers;

use App\DTOs\SearchQuery;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\CartRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Responses\SuccessResponse;
use App\Models\Cart;
use App\Services\AuthService;
use App\Services\BannerService;
use App\Services\CartServiceService;
use Exception;

class CartController extends Controller
{
    private CartServiceService $service;

    public function __construct(CartServiceService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param SearchRequest $request
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        return $this->ok($this->service->me());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return SuccessResponse
     */
    public function show(): SuccessResponse
    {
        return $this->ok($this->service->get(0));
    }

    /**
     * @throws Exception
     */
    public function update(StoreCartRequest $request, int $id): SuccessResponse
    {
        return $this->ok($this->service->save($id, $request->all()));
    }

    /**
     * @throws Exception
     */
    public function store(StoreCartRequest $request): SuccessResponse
    {
        return $this->ok($this->service->create($request->all()));
    }
    public function destroy( int $id): SuccessResponse
    {
        return $this->ok($this->service->delete($id));
    }
}

