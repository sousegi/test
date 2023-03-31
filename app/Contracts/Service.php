<?php
/**
 * Created by IntelliJ IDEA.
 * User: alex.cebotari@ourbox.org
 * Date: 04.10.2021
 * Time: 00:58
 */

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Service interface
 */
interface Service
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder(): Builder;

    /**
     * @param  int  $limit
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllOrderByIdDescPaginated(int $limit = 20): LengthAwarePaginator;

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findAll(): Collection;

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id): Model;

    /**
     * @param  array  $params
     *
     * @return bool
     */
    public function store(array $params): bool;

    /**
     * @param  int  $id
     * @param  array  $params
     *
     * @return bool
     */
    public function update(int $id, array $params): bool;

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array  $params
     *
     * @return bool
     */
    public function updateResource(Model $model, array $params): bool;

    /**
     * @param  int  $id
     */
    public function delete(int $id): void;
}
