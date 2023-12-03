<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(
        AuthService $authService
    ) {
        $this->authService = $authService;
    }

    public function login()
    {
        return inertia('Auth/Login');
    }

    public function doLogin(UserLoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }

    public function me(Request $request)
    {
        return inertia('Auth/Profile', [
            'profile' => $request->user()->only(['id', 'name', 'email']),
        ]);
    }

    public function changePassword()
    {
        return inertia('Auth/ChangePassword');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $this->authService->changePassword([
            'user_id' => $request->user_id,
            'new_password' => $request->new_password,
            'old_password' => $request->current_password,
        ]);

        return redirect('/auth/profile');
    }
}
