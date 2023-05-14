<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticlesCollection;
use App\Models\Article;
use App\Services\ArticleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ArticleController extends APIController
{
    /**
     * @var ArticleService
     */
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        try {
            $collection = $this->articleService->getAllArticles();
            if (!$collection->count()) {
                return response()->json(['message' => 'Empty Articles'], 422);
            }


            return $this->response200((new ArticlesCollection(resource: $collection))->resolve());
        } catch (Exception $e) {
            return $this->response500($e);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function article($id)
    {
        $article = Article::find($id);

        try {

            return $this->response200((new ArticleResource($article))->resolve());
        } catch (Exception $e) {
            return $this->response500($e);
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {

            $data = $request->all();

//            $this->articleService->addArticleData(data: $data, user: $user);
            $article = new Article($data);
            $article->save();

            return $this->response200();

        } catch (\Throwable $th) {
            return $this->response500($th);
        }

    }
}
