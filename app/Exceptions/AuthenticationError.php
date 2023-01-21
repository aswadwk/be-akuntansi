<?php

namespace App\Exceptions;

class AuthenticationError extends ClientError
{
    public function __construct($message='Unauthentication')
    {
        $this->message = $message;
        $this->code = 401;
    }

    public function render()
    {
        return parent::render();
    }
}
