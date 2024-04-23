<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
             'user_id' =>"required|exists:users,id",
             'title' =>"required|string",
             'parking_type' =>"required|string",
            'street1'=>'required|string',
            'city'=>'required|string',
            'country'=>'required|string',
            'phone'=>'required|string',
            'type'=>'required|string'
        ];
    }
}
