<?php

namespace App\Api\Checkout\Domain\Exception;

use RuntimeException;

class InvalidArgumentException extends RuntimeException
{
    public function __construct(string $message = 'Invalid argument provided')
    {
        parent::__construct($message);
    }
}
