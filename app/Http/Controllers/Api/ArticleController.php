<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;


/**
 * @property $ArticleService
 */
class ArticleController extends Controller
{
    /**
     * @var \App\Services\ArticleService
     */
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->service = $articleService;
    }

    /**
     * @return JsonResponse
     */

    public function show(): JsonResponse
    {
        $articles = Article::all();
        return response()->json($articles);
    }
}
