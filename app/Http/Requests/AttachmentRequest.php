<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
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
             'attachment' => 'required|max:20000|mimes:pdf,jpg,jpeg,png,bmp,svg,tiff,mp4,mov,ogg,qt',
             'title' =>"string"
        ];
    }
}
