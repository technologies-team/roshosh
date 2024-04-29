<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\Banner;
use App\Models\Contact;
use Exception;
class ContactService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = [
      'name','email','phone','message'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = [
        'name','email','phone','message'];

    /**
     * searchable field is a field which can be search for from keyword parameter in search method
     */
    protected array $searchables = ['type',];
    /**
     *
     */
    protected array $with = [];

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Contact::query();
    }

    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {

        return parent::prepare($operation, $attributes);
    }

    /**
     * @throws Exception
     */


}
