<?php

namespace App\Http\Requests;

use App\Services\Service;
use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentClinicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        if ($user instanceof \App\Models\User) {
            if ($user->role_id === \App\Models\Role::administrator) {
                return true;
            }
            $service = Container::getInstance()->get(Service::class);
            $clinic = $this->route('id');
            $clinic = $service->find($clinic);
            if ($user->role_id === \App\Models\Role::manager) {

                    return true;

            }
            if ($user->role_id === \App\Models\Role::clinic && $user->id === $clinic->user_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'required|int|exists:clients,id',
            'coupon_id' => 'int|exists:coupons,id',
            'start_time' => 'required|date:Y-m-d\TH:i:sO',
            'services' => 'required|array|min:1',
            'services.*' => 'required|int|exists:clinic_services,id',
        ];
    }
}
