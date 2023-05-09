<?php
/**
 * Created by PhpStorm.
 * User: dmitrii.diam@ourbox.org
 * Date: 27.02.2023
 * Time: 12:08
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class APIController extends Controller
{
    /**
     * @param  array|string[]  $response
     *
     * @return JsonResponse
     */
    public function response200(array $response = ['message' => 'ok']): JsonResponse
    {
        return response()->json($response, JsonResponse::HTTP_OK, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param Throwable $exception
     *
     * @return JsonResponse
     */
    public function response400(Throwable $exception): JsonResponse
    {
        if (env('APP_ENV') != 'local' && app()->bound('sentry')) {
            app('sentry')->captureException($exception);
        }
        return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @param  ValidationException  $exception
     *
     * @return JsonResponse
     */
    public function response422(ValidationException $exception): JsonResponse
    {
        if (env('APP_ENV') != 'local' && app()->bound('sentry')) {
            app('sentry')->captureException($exception);
        }
        return response()->json(['message' => $exception->getMessage(), 'errors' => $exception->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param  \Throwable  $exception
     *
     * @return JsonResponse
     */
    public function response500(Throwable $exception): JsonResponse
    {
        if (env('APP_ENV') != 'local' && app()->bound('sentry')) {
            app('sentry')->captureException($exception);
        }

        return response()->json(['message' => $exception->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

}
