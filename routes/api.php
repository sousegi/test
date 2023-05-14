<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logoutUser']);
Route::get('/articles', [ArticleController::class, 'show']);
Route::get('/article/{id}', [ArticleController::class, 'article']);
Route::post('/article/create', [ArticleController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
