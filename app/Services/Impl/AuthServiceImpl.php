<?php

namespace App\Services\Impl;

use App\Exceptions\AuthenticationError;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthServiceImpl implements AuthService
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

        if (!$token) {
            throw new UnauthorizedException('Unauthentication');
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

    public function changePassword($params)
    {
        $user = User::find($params['user_id']);

        if (!$user) {
            throw new BadRequestException('User tidak ditemukan');
        }

        if (!Hash::check($params['old_password'], $user->password)) {
            throw new BadRequestException('Password lama tidak sesuai');
        }

        $user->password = Hash::make($params['new_password']);
        return $user->save();
    }
};
