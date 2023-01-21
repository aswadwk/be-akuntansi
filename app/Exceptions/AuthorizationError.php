<?php

namespace App\Exceptions;

use App\Helpers\ResponseFormatter;
use Exception;

class AuthorizationError extends ClientError
{
    public function __construct($message)
    {
        $this->message = $message;
        $this->code = 403;
    }

    public function render()
    {
        return parent::render();
    }
}
