<?php

namespace App\Http\Requests;

use App\Services\ServiceService;
use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            $service = Container::getInstance()->get(ServiceService::class);
            $clinic = $this->route('id');
            $clinic = $service->find($clinic);
            $clinic = $clinic->clinic()->get()->first();
            if ($user->role_id === \App\Models\Role::provider) {
                $count = $user->sites()->wherePivot('site_id', '=', $clinic->site_id)->get()->count();
                if ($count === 1) {
                    return true;
                }
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
        ;
        return [
            'title' => 'string',
            'description' => 'string',
            'price' => 'numeric',
            'category_id' => 'int|exists:categories,id',
            'sub_category_id' => 'int|exists:sub_categories,id|nullable',
            'duration' => 'int|min:1',
            'rewards' => 'int',
        ];
    }
}
