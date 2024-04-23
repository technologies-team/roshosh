<?php

namespace App\Services;

use App\Models\Category;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CategoryService extends ModelService
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = ['title', 'photo_id'];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = ['title', 'photo_id'];

    /**
     * searchable field is a field which can be searched for from keyword parameter in search method
     */
    protected array $searchables = ['title'];

    /**
     *
     */
    protected array $with = [];


    private FileService $files;

    public function __construct(FileService $files)
    {
        $this->files = $files;
    }

    /**
     *
     */
    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Category::query();
    }

    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {
        if (isset($attributes['icon_id'])) {
            $icon = $this->files->find($attributes['icon_id']);
            if ($icon instanceof File) {
                if (strpos($icon->mime_type, 'image') !== 0) {
                    throw ValidationException::withMessages(['icon_id' => 'categories:icon:errors:not_image']);
                }
            }
        }
        return parent::prepare($operation, $attributes);
    }

    /**
     * create a new category
     */
    public function store(array $attributes): Model
    {
        $record = parent::store($attributes);
        // TODO: sites attribute value
        if ($record instanceof Category) {
            return $record;

        }
        return $record;
    }
}
