<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticlesCollection;
use App\Models\Article;
use App\Services\ArticleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;


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

//    /**
//     * @return JsonResponse
//     */
//
//    public function show(): JsonResponse
//    {
//        $articles = Article::select('id', 'title', 'content', 'created_at')->get();
//        return response()->json($articles);
//    }

    /**
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        try {
            $collection = $this->articleService->getAllArticles();
            if (!$collection->count()) {
                return response()->json(['message' => 'Empty Categories'], 422);
            }


            return $this->response200((new ArticlesCollection(resource: $collection))->resolve());
        } catch (Exception $e) {
            return $this->response500($e);
        }
    }

    public function article($id)
    {
        $article = Article::find($id);
        return response()->json(new ArticleResource($article));
    }

}
