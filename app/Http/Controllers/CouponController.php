<?php

namespace App\Http\Controllers;

use App\DTOs\SearchQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\BannerService;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private CouponService $service;

    public function __construct(CouponService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param SearchRequest $request
     * @return SuccessResponse
     * @throws \Exception
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
     * @throws \Exception
     */
    public function show(int $id): SuccessResponse
    {
        return $this->ok($this->service->get($id));
    }


    /**
     * @throws \Exception
     */
    public function update(BannerRequest $request, int $id): SuccessResponse
    {
        return $this->ok($this->service->save($id, $request->all()));
    }

    /**
     * @throws \Exception
     */
    public function apply(CouponRequest $request): SuccessResponse
    {
        return $this->ok($this->service->apply($request->all()));
    }

    /**
     * @throws \Exception
     */
    public function remove(): SuccessResponse
    {
        return $this->ok($this->service->removeCoupon());
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $id): SuccessResponse
    {
        return $this->ok($this->service->delete($id));
    }
}
