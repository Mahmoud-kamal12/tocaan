<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->only('name', 'email', 'password'));

        return ApiResponse::success([
            'user'  => new UserResource($user)
        ], 'User registered successfully', 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return ApiResponse::error('Unauthorized', 401);
        }

        $user = auth()->setToken($token)->user();

        return ApiResponse::success([
            'user'  => new UserResource($user),
            'token' => $token,
        ], 'Login successful');
    }
}
