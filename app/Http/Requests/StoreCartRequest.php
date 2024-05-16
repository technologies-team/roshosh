<?php

namespace App\Http\Requests;

use App\Models\Location;
use App\Models\User;
use App\Models\Vehicle;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws Exception
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        // TODO check for site
        if ($user instanceof \App\Models\User) {
            if ($user->hasRole(User::ROLE_CUSTOMER)) {
                $vehicleId = $this->input('vehicle_id');
                $vehicle = $user->vehicles()->find($vehicleId);
                if (!$vehicle instanceof Vehicle) {
                    throw new Exception("this vehicle not exists");

                }
                $locationId = $this->input('location_id');

                $location = $user->locations()->find($locationId);
                if (!$location instanceof Location) {
                    throw new Exception("this location not exists");
                }
            } else {
                if ($user->hasRole(User::ROLE_VENDOR)) {
                    return false;
                }
            }

        }
        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_time' => 'required|date:Y-m-d\TH:i:sO',
            'location_id' => 'int|exists:locations,id',
            'service_id' => 'required|int|exists:services,id',
            'vehicle_id' => 'required|int|exists:vehicles,id',
        ];
    }
}
