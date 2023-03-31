<?php
/** @noinspection PhpUndefinedMethodInspection */

/**
 * Created by PhpStorm.
 * User: alex.cebotari@ourbox.org
 * Date: 19.10.2021
 * Time: 16:54
 */

namespace App\Services;

use App\Models\Language;
use App\Contracts\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use TypeError;

/**
 * Class LanguageService
 * @package App\Services
 */
class LanguageService implements Service
{
    /**
     * @var \App\Models\Language
     */
    public Language $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
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

    /**
     * @param  int  $id
     *
     * @return bool
     */
    public function checkIfLastLanguageAvailableInDashboard(int $id): bool
    {
        return $this->ifLastQueryBuilder($id)
                ->where('admin', true)
                ->count() === 0;
    }

    /**
     * @param  int  $id
     *
     * @return bool
     */
    public function checkIfLastLanguageAvailable(int $id): bool
    {
        return $this->ifLastQueryBuilder($id)
                ->count() === 0;
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function ifLastQueryBuilder(int $id): Builder
    {
        return $this->builder()->where('id', '!=', $id);
    }

    /**
     * Get languages for Dashboard from Cache
     *
     * @return array
     * @noinspection PhpUndefinedMethodInspection
     * @noinspection PhpUnused
     */
    public function getLanguagesForDashboard(): array
    {
        return Cache::rememberForever('languages', function () {
            return Language::where('admin', 1)->get()->toArray();
        });
    }

    /**
     * Get languages for WebSite
     * @return array
     */
    public function getLanguagesForWebsite(): array
    {
        return Cache::rememberForever('languages-web', function () {
            return Language::where('site', 1)->get()->toArray();
        });
    }

    /**
     * Clear languages from Cache
     */
    public function clearLanguageCache(): void
    {
        Cache::forget('languages');
        Cache::forget('languages-web');
    }
}
