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
    private ArticleService $service;

    /**
     * @param  \App\Services\ArticleService $service
     */
    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */

    public function show() {
        $articles = Article::select(['id', 'title', 'content', 'created_at'])->get()
            ->map(function($articles) {
            return [
                'id' => $articles->id,
                'title' => $articles->title,
                'content' => $articles->content,
                'createdAt' => $articles->created_at,
            ];
        });

        try {

            if (!$articles->count()) {
                return response()->json(['message' => 'Empty Articles'], 401);
            }

            return response()->json(['articles' => $articles], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
    }
}
