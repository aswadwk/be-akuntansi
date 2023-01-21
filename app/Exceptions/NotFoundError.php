<?php

namespace App\Exceptions;

use App\Helpers\ResponseFormatter;

class NotFoundError extends ClientError
{
    public function __construct($message)
    {
        $this->message = $message;
        $this->code = 404;
        $this->name = 'NotFoundError';
    }

    public function render()
    {
        return parent::render();
    }
}
