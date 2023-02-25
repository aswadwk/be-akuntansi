<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\Impl\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $service;
    /**
    * Create a new AuthController instance.
    *
    * @return void
    */
    public function __construct(
        AuthService $service,
    ) {
        $this->service = $service;
    }

    public function register(UserRegisterRequest $request)
    {
        $userRequest = $request->safe()->except('password_confirm');
        $this->service->register($userRequest);

        $credential = $request->safe()->only([
            'email','password',
        ]);

        $token = $this->service->login($credential);

        return ResponseFormatter::success($token, 'Berhasil Registrasi User', 201);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        $credential = $request->safe()->only([
            'email','password',
        ]);

        $token = $this->service->login($credential);
        if (! $token) {
            return ResponseFormatter::error('Unauthentication', null, 401);
        }

        return ResponseFormatter::success($token, 'Berhasil Login');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = $this->service->me($request->token);

        return ResponseFormatter::success($user, 'Berhasil');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }
}
