<?php


namespace App\Services;


use App\DTOs\Result;
use App\DTOs\SearchQuery;
use App\DTOs\SearchResult;
use App\Models\Banner;
use Exception;

class HomeService extends Service
{

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

        unset($fromJson->fields["language"]);

        $result['service']=$this->serviceService->search($fromJson);
        return $this->ok($result, 'records:create:done');

    }
}
