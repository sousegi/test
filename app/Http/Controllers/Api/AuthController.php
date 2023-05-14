<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;



/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api
 */

class AuthController extends APIController
{
    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('api_token')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
    }

//    public function logoutUser(Request $request): JsonResponse
//    {
//        if (PersonalAccessToken::findToken($request->bearerToken())->forceDelete()) {
//            return response()->json(['success' => true]);
//        }
//        return response()->json(['success' => false]);
//    }
//}

    public function logoutUser(Request $request): JsonResponse
    {
        try {

            PersonalAccessToken::findToken($request->bearerToken())->delete();
            return response()->json([
                'status'  => true,
                'message' => __(key: 'User Logged Out Successfully.'),
            ], status: Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->response500($th);
        }
    }
}
