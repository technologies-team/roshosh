<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\Book;
use App\Models\BookLog;
use App\Models\Cart;
use App\Models\CartService;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class BookLogService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ["book_id","user_id","new_status","old_status","reason","notes"];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = [

        'status'];

    /**
     * searchable field is a field which can be searched for from keyword parameter in search method
     */
    protected array $searchables = [];
    /**
     *
     */

    protected array $with = ['details'];
    protected CartsService $cartsService;
    protected BookDetailsService $bookDetailsService;
    protected UserService $userService;
    public function __construct(CartsService $cartsService, UserService $userService, BookDetailsService $bookDetailsService)
    {
        $this->cartsService = $cartsService;
        $this->userService = $userService;
        $this->bookDetailsService = $bookDetailsService;
    }
    public function builder(): Builder
    {
        return BookLog::query();
    }
    /**
     * @throws Exception
     */

}
