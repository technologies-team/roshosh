<?php

namespace App\Http\Requests;

use App\Services\ClientService;
use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookClientRequest extends FormRequest
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
            $service = Container::getInstance()->get(ClientService::class);
            $client = $this->route('id');
            $client = $service->find($client);
            if ($user->role_id === \App\Models\Role::provider) {

                    return true;

            }
            if ($user->role_id === \App\Models\Role::client && $user->id === $client->user_id) {
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
            'gateway' => 'string|in:default,rewards',
            'client_id'=>'required|int|exists:clients,id',
            'coupon_id' => 'int|exists:coupons,id',
            'services.*' => 'required|int|exists:clinic_services,id',
        ];
    }
}
