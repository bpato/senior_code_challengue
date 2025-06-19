<?php

namespace App\Api\Cart\Domain\ValueObject;

use App\Api\Cart\Domain\Exception\InvalidArgumentException;

class CartItemQuantity
{
    private int $quantity;

    public function __construct(int $quantity)
    {
        if ($quantity < 0) {
            throw new InvalidArgumentException('Quantity must be a positive integer or zero.');
        }

        $this->quantity = $quantity;
    }

    public function getValue(): int
    {
        return $this->quantity;
    }
}
