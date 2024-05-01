<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\Cart;
use App\Models\CartService;
use App\Models\User;
use Exception;
use GuzzleHttp\Promise\Tests\Thing1;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CartServiceService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['cart_id','vehicle_id','location_id','service_id','service_time',
        'coupon_id',
        'price',
        'quantity',     ];

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
private CartsService $cartsService;
private ServiceService $service;
private UserService $userService;
public function __construct(CartsService $cartsService,UserService $userService,ServiceService $service)
{
    $this->cartsService=$cartsService;
    $this->userService=$userService;
    $this->service=$service;
}

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
    public function store(array $attributes): Model
    {
        $attributes["user_id"]=auth()->user()->getAuthIdentifier();

        $user=$this->userService->find($attributes["user_id"]);
        if($user instanceof User){
            $cart=$user->carts()->first();
             if($cart instanceof Cart){
         $attributes["cart_id"]=$cart->id;
}
             else{
                $cart= $this->cartsService->store($attributes);
            if($cart instanceof Cart){
                $attributes["cart_id"]=$cart->id;
            }
             }
        }
        $attributes["quantity"]=1;
        $service=$this->service->find($attributes["service_id"]);

            $attributes["price"]=$service->price;
        $record = parent::store($attributes);
        // TODO: sites attribute value
        if ($record instanceof Cart) {
            return $record;

        }
        return $record;
    }
    public function create(array $attributes): Result
    {
        $attributes["user_id"]=auth()->user()->getAuthIdentifier();

        return $this->ok($this->store($attributes), 'records:create:done');
    }


}
