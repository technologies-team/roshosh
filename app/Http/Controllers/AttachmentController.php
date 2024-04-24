<?php


namespace App\Http\Controllers;

use App\Dtos\SearchQuery;
use App\Dtos\Result;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateAttachmentRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\AuthService;
use App\Services\AttachmentService;
use App\Services\WishListService;
use App\Http\Requests\AttachmentRequest;
use Exception;
use Illuminate\Http\Response;

class AttachmentController extends Controller
{
    private AttachmentService $service;

    public function __construct(AttachmentService $service)
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
    public function store(AttachmentRequest $request): SuccessResponse
    {
        return $this->ok(new Result($this->service->create($request->all())));
    }




    public function update(UpdateAttachmentRequest $request, int $id): SuccessResponse
    {
        return $this->ok($this->service->update2($id, $request->all()));
    }

    public function destroy(int $id): SuccessResponse
    {
        return $this->ok($this->service->delete($id));
    }
    public function download(string $name)
    {
        return $this->service->download($name);
    }
}
