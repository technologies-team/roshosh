<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\Book;
use App\Models\BookDetail;
use App\Models\Cart;
use App\Models\CartService;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class BookDetailsService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['service_name','location','vehicle','coupon','service_time'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = [];
    /**
     * searchable field is a field which can be searched for from keyword parameter in search method
     */
    protected array $searchables = [];


    public function builder(): Builder
    {
        return BookDetail::query();
    }
    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {

        return parent::prepare($operation, $attributes);
    }

}
