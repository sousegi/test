<?php

namespace App\Services;

use App\Contracts\Service;
use App\Models\Article;
use App\Traits\DropZoneTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use TypeError;

/**
 * Class Article
 * @package App\Services
 */
class ArticleService implements Service
{
    use DropZoneTrait;

    /**
     * @var \App\Models\Article
     */
    public Article $model;

    /**
     * @param  \App\Models\Article  $article
     */
    public function __construct(Article $article)
    {
        $this->model = $article;
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
        $store = $this->model->save();

        if (request()->has('image')) {
            self::moveImage(request()->image);
        }
        return $store;
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
        if (request()->has('image')) {
            self::moveImage(request()->image);
        }
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
     * @return Builder[]|Collection|\Illuminate\Support\Collection
     */
    public function getAllArticles(): Collection|\Illuminate\Support\Collection|array
    {
        return $this->builder()
            ->select(['id', 'title', 'content', 'image', 'created_at'])
            ->where('published' , 1)
            ->get()
            ->map(function($articles) {
                return [
                    'id' => $articles->id,
                    'title' => $articles->title,
                    'content' => $articles->content,
                    'image' => url('/storage/articles/'.$articles->id.'/'.$articles->image),
                    'created_at' => $articles->created_at
                ];
            });
    }

}
