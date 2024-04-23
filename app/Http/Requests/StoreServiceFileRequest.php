<?php

namespace App\Http\Requests;

use App\Services\ServiceService;
use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceFileRequest extends FormRequest
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
            if ($user->role_id === \App\Models\Role::manager) {

                    return true;

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
        return [
            'clinic_service_id' => 'required|int|exists:clinic_services,id',
            'file_id' => 'required|int|exists:files,id',
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param  array|mixed|null  $keys
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['clinic_service_id'] = $this->route('id');
        $data['file_id'] = $this->route('file_id');
        return $data;
    }
}
