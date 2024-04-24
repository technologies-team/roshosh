<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Container\Container;
use Illuminate\Validation\ValidationException;

class LocationService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['title','street1', 'street2', 'phone','verified','country_id', 'city_id' ,'longitude', 'latitude', 'user_id','parking_type','country','city'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['street1', 'street2', 'country_id','phone','verified', 'city_id', 'zip_code', 'longitude', 'latitude'];

    /**
     * searchable field is a field which can be search for from keyword parameter in search method
     */
    protected array $searchables = [];

    /**
     *
     */
    protected array $with = [];

    /**
     *
     */
    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Location::query();
    }

    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {
        return parent::prepare($operation, $attributes);
    }
}
