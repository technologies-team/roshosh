<?php

namespace App\Http\Controllers;

use App\Dtos\SearchQuery;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreBookRequest;

use App\Http\Requests\UpdateBookRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\BookService;
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
     * activate
     *
     * @param int $id
     * @return SuccessResponse
     * @throws Throwable
     */
    public function update(UpdateBookRequest $request,int $id): SuccessResponse
    {
        return $this->ok($this->service->save($id,$request->all()));
    }
    public function store(StoreBookRequest $request): SuccessResponse
    {
        return $this->ok($this->service->create($request->all()));
    }


}
