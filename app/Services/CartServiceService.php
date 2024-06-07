<?php


namespace App\Services;


use App\DTOs\Result;
use App\Models\Cart;
use App\Models\CartService;
use App\Models\Coupon;
use App\Models\Location;
use App\Models\Offer;
use App\Models\User;
use App\Models\Vehicle;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CartServiceService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['cart_id', 'vehicle_id', 'location_id', 'service_id', 'service_time', 'coupon_id', 'price','rewards', 'quantity', 'total_price','total_rewards', 'offer_id'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['coupon_id', 'price', 'quantity', 'total_price','rewards','total_rewards',];

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

    public function __construct(CartsService $cartsService, UserService $userService, ServiceService $service)
    {
        $this->cartsService = $cartsService;
        $this->userService = $userService;
        $this->service = $service;
    }

    public function builder(): Builder
    {
        return CartService::query();
    }

    /**
     * @throws Exception
     */
    public function me(): Result
    {
        $id = auth()->user()->getAuthIdentifier();

        $user = $this->userService->find($id);
        if ($user instanceof User) {
            $cart = $user->carts()->first();
            return $this->ok($cart, 'records:create:done');

        }
        throw new Exception('your cart is empty');
    }

    public function create(array $attributes): Result
    {
        $attributes["user_id"] = auth()->user()->getAuthIdentifier();

        return $this->ok($this->store($attributes), 'records:create:done');
    }

    /**
     * @throws Exception
     */
    public function store(array $attributes): Model
    {
        $cart = $this->getUserCart();
        $attributes["cart_id"] = $cart->id;
        $cart->cartService()->delete();
        $attributes["quantity"] = 1;

        $service = $this->service->find($attributes["service_id"]);
        $price = $service->price;
        $rewards = $service->rewards??0;
        $max = 0;
        if (isset($attributes["offer_id"])) {
            $max = $this->applayOffere($attributes["offer_id"], $service, $price);
        }
        if ($max == 0) {
            unset($attributes["offer_id"]);
        }
        $price = number_format($price - $max, 2, '.', '');
        $attributes["price"] = $price;
        if($rewards){
            $rewards = number_format(($rewards - $max)*100, 2, '.', '');

            $attributes["rewards"] = $rewards;

            $attributes["total_rewards"] = $rewards;
        }
        $attributes["total_price"] = $price;
        // TODO: sites attribute value
        return parent::store($attributes);
    }

    /**
     * @throws Exception
     */
    public function getUserCart(): Cart
    {
        $user_id = auth()->user()->getAuthIdentifier();

        $user = $this->userService->find($user_id);
        if ($user instanceof User) {
            $cart = $user->carts()->first();
            if ($cart instanceof Cart) {
                return $cart;
            } else {
                $attributes["user_id"] = $user_id;
                $cart = $this->cartsService->store($attributes);
                if ($cart instanceof Cart) {
                    return $cart;
                }
            }
        }
        throw new Exception("there is user error");
    }

    public function calcDiscount($price, $type, $value, $max)
    {
        return match ($type) {
            "percent_limited", "percent" => $max > 0 ? min((($price * $value) / 100), $max) : ($price * $value) / 100,
            "fixed" => min($value, $price),
            default => 0,
        };
    }


    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {

        return parent::prepare($operation, $attributes);
    }

    private function applayOffere(mixed $offer_id, $service, $price): int
    {
        $offer = $service->offers()->find($offer_id);
        if ($offer instanceof Offer) {
            if (isset($offer->min_amount) && $offer->min_amount > $price) {
                return 0;
            }
            return $this->calcDiscount($price, $offer->type, $offer->value, $offer->percent_limited);
        }
        return 0;
    }

}
