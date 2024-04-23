<?php

namespace App\Http\Requests;

use App\Services\Service;
use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
//            if ($user->role_id === \App\Models\Role::administrator) {
                return true;
//            }
//            $service = Container::getInstance()->get(Service::class);
//            $clinic = $this->get('clinic_id');
//            $clinic = $service->find($clinic);
//            if ($user->role_id === \App\Models\Role::provider) {
//                $count = $user->sites()->wherePivot('site_id', '=', $clinic->site_id)->get()->count();
//                if ($count === 1) {
//                    return true;
//                }
//            }
//            if ($user->role_id === \App\Models\Role::clinic && $user->id === $clinic->user_id) {
//                return true;
//            }
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
            'title' => 'required|string',
            'title_ar' => 'string',
            'parent_id' => 'int|exists:services,id',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|int|exists:categories,id',
            'rewards' => 'int',
        ];
    }
}
