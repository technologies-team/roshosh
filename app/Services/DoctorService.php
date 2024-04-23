<?php

namespace App\Services;

use App\Models\ClinicDoctor;
use Illuminate\Validation\ValidationException;

class DoctorService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = [ 'user_id', 'specialization', 'curriculum_vitae_id'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['specialization', 'curriculum_vitae_id'];

    /**
     * searchable field is a field which can be search for from keyword parameter in search method
     */
    protected array $searchables = ['specialization'];

    /**
     *
     */
    protected array $with = [];

    /**
     *
     */
    private UserService $users;

    /**
     *
     */
    private FileService $files;

    /**
     *
     */
    public function __construct(UserService $users, FileService $files)
    {
        $this->users = $users;
        $this->files = $files;
    }

    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {
        if (isset($attributes['curriculum_vitae_id'])) {
            $cv = $this->files->find($attributes['curriculum_vitae_id']);
            if ($cv instanceof \App\Models\File) {
                $supported_cv = [
                    "application/pdf",
                    "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                ];
                if (!in_array($cv->mime_type, $supported_cv)) {
                    throw ValidationException::withMessages(['curriculum_vitae_id' => 'clinics:doctors:curriculum_vitae_id:errors:not_supported']);
                }
            }
        }
        return parent::prepare($operation, $attributes);
    }


    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return ClinicDoctor::query();
    }

    /**
     * create a new clinic doctor
     */
    public function store(array $attributes): ClinicDoctor
    {
        try {
            //
            // create the user
            $user = $attributes['user'];
            $user['role_id'] = \App\Models\Role::doctor;
            $user['status'] = \App\Models\User::status_active;

            $user = $this->users->store($user);
            $attributes['user_id'] = $user->id;

            $record = parent::store($attributes);
            //
            return $record;
        } catch (\Throwable $th) {
            if (isset($record) && $record instanceof \App\Models\ClinicDoctor) {
                $record->delete();
            }
            if (isset($user) && $user instanceof \App\Models\User) {
                $user->delete();
            }
            throw $th;
        }
    }


    /**
     * update clinic doctor
     */
    public function update(mixed $id, array $attributes): ClinicDoctor
    {
        $record = $this->find($id);
        if ($record instanceof ClinicDoctor) {
            if (isset($attributes['user'])) {
                $this->users->update($record->user_id, $attributes['user']);
            }
        }
        return  parent::update($id, $attributes);
    }

    /**
     * delete inner
     */
    public function destroy(mixed $id)
    {
        $record = $this->find($id);
        $user_id = (int) $record->user_id;
        // 1.
        $d = parent::destroy($id);
        // 2.
        $this->users->destroy($user_id);
        return $d;
    }
}
