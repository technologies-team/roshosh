<?php


namespace App\Services;


use App\DTOs\Result;
use App\Models\Banner;
use App\Models\Offer;
use Exception;

class OfferService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = [
        'title',
        'photo_id', 'description'
    ];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = [
        'title',
        'photo_id', 'description'
    ];

    /**
     * searchable field is a field which can be search for from keyword parameter in search method
     */
    protected array $searchables = ['title',];
    /**
     *
     */
    protected array $with = ['services'];

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Offer::query();
    }

    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {

        return parent::prepare($operation, $attributes);
    }

    /**
     * @throws Exception
     */
}
