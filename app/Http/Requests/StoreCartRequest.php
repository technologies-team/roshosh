<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
          return  true;
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
            'session_id' => 'int',
            'coupon_ids.*' => 'int|exists:coupons,id',
            'service_time' => 'required|date:Y-m-d\TH:i:sO',
            'location_ids.*' => 'int|exists:locations,id',
            'services_ids.*' => 'required|int|exists:services,id',
        ];
    }
}
