<?php

namespace App\Http\Controllers;

use App\DTOs\Result;
use App\DTOs\SearchQuery;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\VehicleRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\AuthService;
use App\Services\BannerService;
use App\Services\ContactService;
use App\Services\VehicleService;
use Exception;

class ContactController extends Controller
{
    private ContactService $service;

    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param SearchRequest $request
     * @return SuccessResponse
     * @throws Exception
     */
    public function index(SearchRequest $request): SuccessResponse
    {
        return $this->ok($this->service->search(SearchQuery::fromJson($request->all())));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return SuccessResponse
     * @throws Exception
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
        return $this->ok($this->service->save($id, $request->all()));
    }

    /**
     * @throws Exception
     */
    public function store(StoreContactRequest $request): SuccessResponse
    {
        return $this->ok($this->service->create($request->all()));
    }

    /**
     * @throws Exception
     */
    public function destroy(int $id): SuccessResponse
    {
        return $this->ok($this->service->delete($id));
    }    public function terms($lang="en"): SuccessResponse{
    if($lang=="ar"){
        return $this->ok(new Result(["view"=>view('terms_ar')->render()],"",200) );
    }
    else
        return $this->ok(new Result(["view"=>view('terms')->render()],"",200) );

    }
}

