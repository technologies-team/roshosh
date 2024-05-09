<?php

namespace App\Http\Controllers;

use App\Dtos\SearchQuery;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\VehicleRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\VehicleService;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use JetBrains\PhpStorm\NoReturn;

class VehiclesController extends Controller
{
    private VehicleService $service;

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
     * @throws ConnectionException
     */
    public function models(SearchRequest $request): SuccessResponse
    {
        return $this->ok($this->service->cars(SearchQuery::fromJson($request->all())));
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

