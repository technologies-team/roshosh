<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
                return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|unique:categories,title',
            'photo_id' => 'required|int|exists:attachments,id',
            'parent_id' => 'int|exists:categories,id',
        ];
    }
}
