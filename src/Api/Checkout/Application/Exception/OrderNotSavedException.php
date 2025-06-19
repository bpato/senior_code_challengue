<?php

namespace App\Api\Checkout\Application\Exception;

use RuntimeException;

class OrderNotSavedException extends RuntimeException
{
    public function __construct(string $message = 'Order could not be saved')
    {
        parent::__construct($message);
    }
}
