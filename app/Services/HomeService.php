<?php


namespace App\Services;


use App\Dtos\Result;
use App\Dtos\SearchQuery;
use App\Dtos\SearchResult;
use App\Models\Banner;
use Exception;

class HomeService extends ModelService
{
    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Banner::query();
    }

private  BannerService $bannerService;

    private ServiceService $serviceService;
    public function __construct(BannerService $bannerService, ServiceService $serviceService)
    {
        $this->bannerService=$bannerService;
        $this->serviceService=$serviceService;
    }
    public function index($fromJson): Result


    {
        $result['banner']=$this->bannerService->search($fromJson);
        $result['service']=$this->serviceService->search($fromJson);
        return $this->ok($result, 'records:create:done');

    }

    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {

        return parent::prepare($operation, $attributes);
    }

}
