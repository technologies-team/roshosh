<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CartService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['user_id'
       ];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['user_id'];

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
        return Cart::query();
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
    public function store(array $attributes): Model
    {
        $attributes["user_id"]=auth()->user()->getAuthIdentifier();
        $cart=$this->find($attributes["user_id"]);
        if ($cart instanceof Cart) {
            return $cart;

        }
        $record = parent::store($attributes);
        // TODO: sites attribute value
        if ($record instanceof Cart) {
            return $record;

        }
        return $record;
    }

}
