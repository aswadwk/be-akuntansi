<?php

namespace App\Services\Impl;

use App\Exceptions\AuthenticationError;
use App\Models\User;
use App\Services\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function register($attr)
    {
        if ($this->emailIsExist($attr['email'])) {
            throw ValidationException::withMessages(['email' => 'Email tidak tersedia']);
        }

        $attr['password'] = Hash::make($attr['password']);

        return  User::create($attr);
    }

    public function login($credential)
    {
        $token = auth('api')->attempt($credential);

        if (! $token) {
            throw new AuthenticationError();
        }

        return $this->respondWithToken($token);
    }

    public function refreshToken($olToken)
    {
        return auth('api')->refresh();
    }

    public function logout($token)
    {
    }

    public function me($token)
    {
        return auth('api')->user();
    }

    protected function respondWithToken($token)
    {
        return [
            'token_type'   => 'bearer',
            'access_token' => $token,
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ];
    }

    public function emailIsExist($email): bool
    {
        return User::where('email', $email)->exists();
    }
}



;
