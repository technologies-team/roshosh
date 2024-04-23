<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\CartItem;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class CartItemService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = [
       ];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = [];

    /**
     * searchable field is a field which can be searched for from keyword parameter in search method
     */
    protected array $searchables = [];
    /**
     *
     */
    protected array $with = [];

    public function builder(): Builder
    {
        return CartService::query();
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
