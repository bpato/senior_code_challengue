<?php

namespace App\Api\Checkout\Domain\Exception;

use RuntimeException;
use App\Api\Checkout\Domain\ValueObject\OrderId;

class OrderNotFoundException extends RuntimeException
{
    public function __construct(OrderId $orderId)
    {
        parent::__construct('Order not found with ID: ' . $orderId->getValue());
    }
}
