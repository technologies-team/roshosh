<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class ServiceService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['title', 'title_ar', 'description', 'description_ar', 'price', 'category_id', 'rewards', 'photo_id'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['title', 'description', 'title_ar', 'description_ar', 'price', 'category_id', 'rewards', 'avatar_id'];

    /**
     * searchable field is a field which can be searched for from keyword parameter in search method
     */
    protected array $searchables = ['title', 'description', 'title_ar', 'description_ar'];

    /**
     *
     */
    protected array $with = ['category', 'avatar', 'offers'];


    private CategoryService $categories;

    public function __construct(CategoryService $categories)
    {
        $this->categories = $categories;
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Service::query();
    }

    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {
        if (isset($attributes['category_id']) && isset($attributes['sub_category_id'])) {
            $category = $this->categories->find($attributes['category_id']);
            if ($category instanceof Category) {
                throw ValidationException::withMessages(['sub_category_id' => 'clinicsservices:sub_category_id:invalid']);

            }
        }
        return parent::prepare($operation, $attributes);
    }

    public function show()
    {
        return;
    }

    public function rewards(array $services)
    {
        $services = $this->builder()->whereIn('id', $services)->get();
        $rewards = 0;
        foreach ($services as $i => $service) {
            if (!$service->rewards) {
                throw ValidationException::withMessages(['services.' . $i => 'clinicsservices:rewards:not_configured']);
            }
            $rewards = $rewards + $service->rewards;
        }
        return $rewards;
    }

    /**
     * @throws \Exception
     */
    public function calcPrice($serviceId, $offerId)
    {
        $service = $this->find($serviceId);
        $offer = $service->offers()->find($offerId);
        $currentTime = Carbon::now();
        if ($offer->min_amount > $service->price || !$currentTime->between($offer->start_at, $offer->expires_at)) {
            return $service->price;
        }
        return match ($offer->type) {
            "percent_limited", "percent" => $service->price - ($offer->percent_limited > 0 ? min((($service->price * $offer->value) / 100), $offer->percent_limited) : ($service->price * $offer->value) / 100),
            "fixed" => $service->price - (min($offer->value, $service->price)),
            default => $service->price,
        };
    }

    /**
     * @throws Exception
     */
    public function get($id): \App\Dtos\Result
    {
        $service = $this->find($id);
        if ($service instanceof Service) {
            $offers = $service->offers()->get();
            $prices = array();
            foreach ($offers as $offer) {
                $prices[] =["id"=>$offer->id,"price"=> $this->calcPrice($service->id, $offer->id)];
            }
        }
        $data = [$service];
        $data["prices"] = $prices;
        return $this->ok($data, "record fetch success");
    }

}
