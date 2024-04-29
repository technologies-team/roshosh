<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\vehicle;
use Exception;
class VehicleService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = [
        'type',
        'color','make','model','license_plate','vehicle_type'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['type',
        'color','make','model','license_plate','vehicle_type'];

    /**
     * searchable field is a field which can be search for from keyword parameter in search method
     */
    protected array $searchables = ['type',];
    /**
     *
     */
    protected array $with = [];

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Vehicle::query();
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
