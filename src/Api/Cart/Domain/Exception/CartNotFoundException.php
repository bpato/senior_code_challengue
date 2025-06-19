<?php

namespace App\Api\Cart\Domain\Exception;

use RuntimeException;
use App\Api\Cart\Domain\ValueObject\CartId;

class CartNotFoundException extends RuntimeException
{
    public function __construct(CartId $cartId)
    {
        parent::__construct('Cart not found with ID: ' . $cartId->getValue());
    }
}
