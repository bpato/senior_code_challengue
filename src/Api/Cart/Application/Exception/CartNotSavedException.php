<?php

namespace App\Api\Cart\Application\Exception;

use RuntimeException;

class CartNotSavedException extends RuntimeException
{
    public function __construct(string $message = 'Cart could not be saved')
    {
        parent::__construct($message);
    }
}
