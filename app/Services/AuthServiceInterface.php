<?php

namespace App\Services;

interface AuthServiceInterface {

    public function register($attr);

    public function login($credential);

    public function refreshToken($oldToken);

    public function logout($token);

    public function me($token);
}


;?>
