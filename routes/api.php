<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::get('/articles', [ArticleController::class, 'getAllArticles']);
Route::get('/article/{id}', [ArticleController::class, 'article']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/myarticles', [ArticleController::class, 'myArticles']);

    Route::post('/auth/logout', [AuthController::class, 'logoutUser']);

    Route::post('/article/create', [ArticleController::class, 'store']);

});
