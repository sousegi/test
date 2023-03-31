<?php

namespace App\Services;

use App\Models\Admin;
use App\Contracts\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use TypeError;

/**
 * Class Admin
 * @package App\Services
 */
class AdminService implements Service
{
    /**
     * @var \App\Models\Admin
     */
    public Admin $model;

    /**
     * @param  \App\Models\Admin  $admin
     */
    public function __construct(Admin $admin)
    {
        $this->model = $admin;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder(): Builder
    {
        return $this->model->select()->where('is_super', 0);
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
        $this->hashPasswordIfPresented($params);
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
        $this->hashPasswordIfPresented($params);
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

        $this->hashPasswordIfPresented($params);
        $this->model = $model;
        return $this->model->update($params);
    }

    /**
     * method for checking the array for a password, and if the password is present, hashing it
     *
     * @param  array  $params
     */
    private function hashPasswordIfPresented(array &$params): void
    {
        if (isset($params['password']) && !empty($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        } else {
            unset($params['password']);
        }
    }

    /**
     * @param  int  $id
     */
    public function delete(int $id): void
    {
        $this->builder()->where('id', $id)->delete();
    }
}
