<?php

namespace App\Exceptions;

class InvariantError extends ClientError
{
    public function __construct($message)
    {
        $this->message = $message;
        $this->code = 400;
        $this->name = 'InvariantError';
    }

    public function render()
    {
        return parent::render();
    }
}
