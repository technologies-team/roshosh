<?php


namespace App\Services;


use App\DTOs\Result;
use App\DTOs\SearchQuery;
use App\Models\CartService;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use JetBrains\PhpStorm\NoReturn;

class VehicleService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = [
        'type','user_id',
        'color','make','model','license_plate','vehicle_type'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['type','user_id',
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
    protected CarModelService $carModels;
    public function __construct(CarModelService $carModels){
        $this->carModels=$carModels;
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
    public function create(array $attributes): Result
    {
        if(!isset($attributes['user_id'])){
            $attributes['user_id']=auth()->id();
        }
        return $this->ok($this->store($attributes), 'vehicle:saved:succeeded');
    }

    /**
     * @throws ConnectionException|Exception
     */
    #[NoReturn] public function cars(SearchQuery $q): Result
    {
        return $this->ok($this->carModels->search( $q));
    }
}
