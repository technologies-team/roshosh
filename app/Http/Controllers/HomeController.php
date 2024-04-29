<?php

namespace App\Http\Controllers;

use App\Dtos\SearchQuery;
use App\Http\Requests\SearchRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\HomeService;

class HomeController extends Controller
{
private HomeService $service;

    public function __construct( HomeService $service)
    {
   $this->service=$service;
    }
    /**
     * Display a listing of the resource.
     *
     * @param SearchRequest $request
     * @return SuccessResponse
     */
    public function index(SearchRequest $request): SuccessResponse
    {
        return $this->ok($this->service->index(SearchQuery::fromJson($request->all())));
    }
}
