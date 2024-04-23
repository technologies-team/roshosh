<?php

namespace App\Http\Controllers;

use App\Dtos\SearchQuery;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\updateLocationRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\AuthService;
use App\Services\BannerService;
use App\Services\CategoryService;
use App\Services\LocationService;
use App\Services\ServiceService;
use App\Services\WishListService;

class ServiceController extends Controller
{
    private ServiceService $service;

    public function __construct(ServiceService $service)
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
     * @throws \Exception
     */
    public function update(updateServiceRequest $request, int $id): SuccessResponse
    {
        return $this->ok($this->service->update($id, $request->all()));
    }

    public function store(StoreServiceRequest $request): SuccessResponse
    {
        return $this->ok($this->service->create($request->all()));
    }
    public function destroy( int $id): SuccessResponse
    {
        return $this->ok($this->service->delete($id));
    }
}

