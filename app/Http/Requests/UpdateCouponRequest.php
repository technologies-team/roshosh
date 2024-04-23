<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        // TODO check for site
        if ($user instanceof \App\Models\User) {
            if ($user->role_id === \App\Models\Role::administrator) {
                return true;
            }
            if ($user->role_id === \App\Models\Role::manager) {
                return true;
            }
            if ($user->role_id === \App\Models\Role::clinic) {
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
            'name' => 'string|unique:coupons,name,'.$this->route('id'),
            'description' => 'string',
            'type' => 'string|in:cash,percent,percent_limited',
            'value.percent' => 'int|min:0|max:100',
            'value.limit' => 'int',
            'clients' => 'array',
            'clients.*' => 'int|exists:clients,id',
            'clinics' => 'array',
            'clinics.*' => 'int|exists:clinics,id',
            'services' => 'array',
            'services.*' => 'int|exists:clinic_services,id',
            'start_at'=>'required|date:Y-m-d\TH:i:sO',
            'expires_at'=>'required|date:Y-m-d\TH:i:sO',
            'enabled'=>'boolean',
            'count'=>'int'
        ];

    }
}
