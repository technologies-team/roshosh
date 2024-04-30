<?php

namespace App\Services;

use App\Dtos\Result;
use App\Dtos\SearchQuery;
use App\Dtos\SearchResult;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class ModelService extends Service
{
    /**
     * storable field is a field which can be filled during creating the record
     */
    protected array $storables = [];

    /**
     * updatable field is a field which can be filled during updating the record
     */
    protected array $updatables = [];

    /**
     * searchable field is a field which can be search for from keyword parameter in search method
     */
    protected array $searchables = [];

    /**
     *
     */
    protected array $with = [];

    /**
     * model
     */
    public abstract function builder(): Builder;

    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {
        $fillables = $operation === 'store' ? $this->storables : $this->updatables;
        $result = array_merge([], $attributes);
        $result = $result ? $result : [];
        $result = array_filter($result, fn ($key) => array_search($key, $fillables) !== false, ARRAY_FILTER_USE_KEY);
        return $result;
    }


    /**
     * search
     */
    public function search(SearchQuery $q): SearchResult
    {
        $qb = $this->builder();

        //
        // handle fields
        foreach ($q->fields as $key => $field) {
            $qb = \App\Helpers\QueryBuilder::onFilter($qb, $key, $field);
        }
        //
        // handle keyword
        if (!empty($q->keyword) && !empty($this->searchables)) {
            $keyword = $q->keyword;
            $qb = $qb->where(function (Builder $qb) use ($keyword) {

                foreach ($this->searchables as $field) {
                    $filter = [
                        'operation' => 'LIKE',
                        'value' => '%' . $keyword . '%',
                    ];
                    $qb = \App\Helpers\QueryBuilder::onFilter($qb, $field, $filter, 'or');
                }
            });
        }
        //
        // handle sort
        if (!$q->sort) {
            $column = $q->sort['column'];
            $order = $q->sort['order'];
            $qb->getQuery()->orderBy($column, $order);
        }
        // paginate
        $page = ceil($q->offset * 1.0 / $q->limit + ($q->offset % $q->limit));
        return new SearchResult($qb->paginate($q->limit, ['*'], 'page', $page), 'records:search:done');
    }

    /**
     * create inner code
     */
    public function store(array $attributes): Model
    {
        $fields = $this->prepare('store', $attributes);
        try {
        $record = $this->builder()->create($fields);

        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());

        }

        if (!$record instanceof Model) {
            throw new \Exception('records:store:errors:not_stored');
        }
        return $record;
    }

    /**
     * create
     * @throws \Exception
     */
    public function create(array $attributes): Result
    {
       // dd("dfdfd");
        return $this->ok($this->store($attributes), 'records:create:done');
    }

    /**
     * find
     */
    public function find( $id): Model
    {
        $qb = $this->builder();

        if ($id == null) {
            throw new \Exception('records:find:errors:not_found');
        } else if (is_array($id)) {
            if (!count($id)) {
                throw new \Exception('records:find:errors:not_found');
            }
            foreach ($id as $k => $value) {
                $qb = $qb->where($k, '=', $value);
            }
        } else {
            $qb = $qb->where('id', '=', $id);
        }
        $qb = $qb->with($this->with);
        $qb = $qb->first();
        if (!$qb instanceof Model) {
            throw new \Exception('records:find:errors:not_found');
        }
        return $qb;
    }

    /**
     * get address
     */
    public function get( $id)
    {
        return $this->ok($this->find($id), 'records:get:done');
    }

    /**
     * save inner
     */
    public function update( $id, array $attributes): Model
    {
        $fields = $this->prepare('update', $attributes);
        $record = $this->find($id);
        if (!$record->update($fields)) {
            throw new \Exception('records:update:errors:not_updated');
        }
        return ($record);

    }

    /**
     * save
     * @throws \Exception
     */
    public function save( $id, array $attributes)
    {
        return $this->ok($this->update($id, $attributes), 'records:save:done');
    }
    public function saveInvoice( $id, array $attributes)
    {
        return $this->ok($this->storeInvoice($id, $attributes), 'records:save:done');
    }
    /**
     * delete inner
     */
    public function destroy( $id)
    {
        $record = $this->find($id);
        if (!$record->delete()) {
            throw new \Exception('records:destroy:errors:not_destroyed');
        }
        return $id;
    }

    /**
     * delete
     */
    public function delete( $id)
    {
        return $this->ok($this->destroy($id), 'records:delete:done');
    }
}
