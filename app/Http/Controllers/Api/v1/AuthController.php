<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Auth\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginRequest;
use App\Http\Requests\Api\v1\Auth\RegisterRequest;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $token = $user->createToken('token');

            return response()->json([
                'message' => __('auth.login.success'),
                'token' => $token->plainTextToken,
                'user' => new UserResource($user)
            ]);
        }

        return response()->json([
            'message' => __('auth.login.failed')
        ], 400);
    }

    /**
     * @param RegisterRequest $request
     * @param CreateUserAction $createUserAction
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, CreateUserAction $createUserAction): JsonResponse
    {
        if ($createUserAction->handle($request->validated())) {
            return response()->json([
                'message' => __('auth.register.success')
            ]);
        }

        return response()->json([
            'message' => __('auth.register.failed')
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);
        $token->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('auth.logout.success')
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($request->user())
        ]);
    }
}
