<?php

namespace App\Api\Cart\Domain\ValueObject;

use App\Api\Cart\Domain\Exception\InvalidArgumentException;

class CartItemPrice
{
    private float $price;

    public function __construct(float $price)
    {
        if ($price < 0) {
            throw new InvalidArgumentException('Price cannot be negative');
        }

        $this->price = $price;
    }

    public function getValue(): float
    {
        return $this->price;
    }
}
