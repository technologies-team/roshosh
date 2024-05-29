<?php


namespace App\Http\Controllers;

use App\DTOs\SearchQuery;
use App\DTOs\Result;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\AuthService;
use App\Services\AttachmentService;
use App\Http\Requests\AttachmentRequest;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
    public function store(AttachmentRequest $request): SuccessResponse
    {
        return $this->ok(new Result($this->service->create($request->all())));
    }

    /**
     * @throws Exception
     */
    public function destroy(int $id): SuccessResponse
    {
        return $this->ok($this->service->delete($id));
    }

    /**
     * @throws Exception
     */
    public function download(string $name): StreamedResponse
    {
        return $this->service->download($name);
    }
}
