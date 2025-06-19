<?php

namespace App\Api\Checkout\Domain\ValueObject;

use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class Price
{

    private float $amount;

    public function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException(sprintf('Invalid Price Amount: %s', $amount));
        }

        $this->amount = $amount;
    }

    public function getValue(): float
    {
        return $this->amount;
    }
}
