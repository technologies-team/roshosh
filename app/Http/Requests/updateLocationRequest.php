<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class updateLocationRequest extends FormRequest
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
             'user_id' =>"exists:users,id",
             'title' =>"string",
             'parking_type' =>"string",
             'street1'=>'string',
             'city'=>'string',
             'country'=>'string',
             'phone'=>'string',
             'type'=>'string'
        ];
    }
}
