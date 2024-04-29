<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'user_id'=>"int|exists:users,id",
             'type' =>"required|string",
            'make'=>"required|string",
            'model'=>"string",
            'color'=>"required|string",
            'license_plate'=>"string",
        ];
    }
}
