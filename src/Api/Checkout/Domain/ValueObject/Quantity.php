<?php

namespace App\Api\Checkout\Domain\ValueObject;

use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class Quantity
{

    private int $quantity;

    public function __construct(int $quantity)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException(sprintf('Invalid Quantity: %s', $quantity));
        }

        $this->quantity = $quantity;
    }

    public function getValue(): int
    {
        return $this->quantity;
    }
}
