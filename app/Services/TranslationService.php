<?php

namespace App\Services;

use App\Models\Translation;
use App\Contracts\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use TypeError;

/**
 * Class Translation
 * @package App\Services
 */
class TranslationService implements Service
{
    /**
     * @var \App\Models\Translation
     */
    public Translation $model;

    /**
     * @param  \App\Models\Translation  $translation
     */
    public function __construct(Translation $translation)
    {
        $this->model = $translation;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder(): Builder
    {
        return $this->model->select();
    }

    /**
     * @param  int  $limit
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllOrderByIdDescPaginated(int $limit = 20): LengthAwarePaginator
    {
        return $this->builder()->orderBy('id', 'DESC')->paginate($limit);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAll(): Collection
    {
        return $this->builder()->get();
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id): Model
    {
        return $this->builder()->where('id', $id)->firstOrFail();
    }

    /**
     * @param  array  $params
     *
     * @return bool
     */
    public function store(array $params): bool
    {
        $this->model->fill($params);
        return $this->model->save();
    }

    /**
     * @param  int    $id
     * @param  array  $params
     *
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        return $this->builder()->where('id', $id)->update($params);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array                                $params
     *
     * @return bool
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     */
    public function updateResource(Model $model, array $params): bool
    {
        if (get_class($model) !== get_class($this->model)) {
            throw new TypeError('Cannot assign ' . get_class($this->model) . ' to property of type ' . get_class($this->model));
        }

        $this->model = $model;
        return $this->model->update($params);
    }

    /**
     * @param  int  $id
     */
    public function delete(int $id): void
    {
        $this->builder()->where('id', $id)->delete();
    }
}
