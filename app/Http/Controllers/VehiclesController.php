<?php

namespace App\Http\Controllers;

use App\Dtos\SearchQuery;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\VehicleRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\AuthService;
use App\Services\BannerService;
use App\Services\VehicleService;
use App\Services\WishListService;
use Exception;

class VehiclesController extends Controller
{
    private $service;

    public function __construct(VehicleService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param SearchRequest $request
     * @return SuccessResponse
     */
    public function index(SearchRequest $request): SuccessResponse
    {
        return $this->ok($this->service->search(SearchQuery::fromJson($request->all())));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return SuccessResponse
     */
    public function show(int $id): SuccessResponse
    {
        return $this->ok($this->service->get($id));
    }

    /**
     * @throws Exception
     */
    public function update(VehicleUpdateRequest $request, int $id): SuccessResponse
    {
        return $this->ok($this->service->update($id, $request->all()));
    }

    public function store(VehicleRequest $request): SuccessResponse
    {
        return $this->ok($this->service->create($request->all()));
    }
    public function destroy( int $id): SuccessResponse
    {
        return $this->ok($this->service->delete($id));
    }
}

