<?php

namespace App\Http\Controllers;

use App\DTOs\SearchQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\BookTimeService;
use App\Services\HomeService;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    //

    private BookTimeService $service;

    public function __construct(BookTimeService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param SearchRequest $request
     * @return SuccessResponse
     */
    public function index(Request $request): SuccessResponse
    {

        return $this->ok($this->service->bookTime($request->all()));
    }
}
