<?php

namespace App\Services;

use App\Models\Country;

class CountryService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['name', 'code'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['name', 'code'];

    /**
     * searchable field is a field which can be search for from keyword parameter in search method
     */
    protected array $searchables = ['code'];

    /**
     * 
     */
    protected array $with = [];


    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Country::query();
    }
}
