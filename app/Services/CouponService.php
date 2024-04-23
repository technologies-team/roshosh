<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Container\Container;

class CouponService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['name', 'description', 'type', 'value',   'start_at', 'expires_at','enabled','clinic_id'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['description', 'type', 'value',   'start_at', 'expires_at','enabled','clinic_id'];

    /**
     * searchable field is a field which can be search for from keyword parameter in search method
     */
    protected array $searchables = ['name'];

    /**
     *
     */
    protected array $with = ['users', 'services', 'sites','clinic'];


    /**
     *
     */
    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
       // dd(Coupon::query());
        return Coupon::query();

    }

    protected function prepare(string $operation, array $attributes): array
    {
        if(auth()->user()->role_id == 3){
            $attributes['clinic_id'] = auth()->user()->clinics[0]->id;
        }
        return parent::prepare($operation, $attributes);
    }

    private function attachRelations(Coupon $coupon, array $attributes)
    {
        //
        // 1. store or update users
        //
      //  dd($attributes);
        if (isset($attributes['users'])) {
            $users = (array) $attributes['users'];
            $coupon->users()->detach();
            // TODO: sites attribute value
            $coupon->users()->attach($users, ['site_id' => 1]);
        }
        //
        // 2. store or update services
        //
        if (isset($attributes['services'])) {
            $services = (array) $attributes['services'];
            $coupon->services()->detach();
            $coupon->services()->attach($services);
        }
    }

    /**
     * create a new coupon
     */
    public function store(array $attributes): Coupon
    {
        $record = parent::store($attributes);
        //
        //
        $this->attachRelations($record, $attributes);
        // TODO: sites attribute value
        if ($record instanceof Coupon) {
            //
            // TODO: sites attribute value
            $record->sites()->attach([1]);
        }
        return $record;
    }

    /**
     * save coupon
     */
    public function update( $id, array $attributes): Coupon
    {
        $record = parent::update($id, $attributes);
        //
        $this->attachRelations($record, $attributes);
        return $record;
    }

    /**
     * is valid coupon
     */
    public function isValidCoupon(array $attributes): bool
    {
        if (isset($attributes['coupon_id'])) {
            $coupon = $this->find($attributes['coupon_id']);
            if ($coupon instanceof Coupon) {
                $site_id = $attributes['site_id'];
                //
                $count = $coupon->where('start_at', '<=', $attributes['start_time'])
                        ->where('expires_at', '>=', $attributes['start_time'])
                        ->count();
                    if ($count === 0) {
                        return false;
                    }
                //
                $client_id = $attributes['client_id'];
                $clients = Container::getInstance()->get(ClientService::class);
                $user_id = $clients->find($client_id)->user_id;
                if ($coupon->users()->wherePivot('user_id', '=', $user_id)->wherePivot('site_id', '=', $site_id)->get()->count() === 1) {
                    return true;
                }
                //
                //
                $clinic_id = $attributes['clinic_id'];
                $clinics = Container::getInstance()->get(Service::class);
                $user_id = $clinics->find($clinic_id)->user_id;
                if ($coupon->users()->wherePivot('user_id', '=', $clinic_id)->wherePivot('site_id', '=', $site_id)->get()->count() === 1) {
                    return true;
                }
                //
                //
                $services = $attributes['services'];
                if ($coupon->services()->wherePivotIn('clinic_service_id', $services)->get()->count() === count($services)) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }
}
