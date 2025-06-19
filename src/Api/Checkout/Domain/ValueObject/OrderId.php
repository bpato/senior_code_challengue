<?php

namespace App\Api\Checkout\Domain\ValueObject;

use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class OrderId
{

    private int $id;

    public function __construct(int $id)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException(sprintf('Invalid Order ID: %s', $id));
        }

        $this->id = $id;
    }

    public function getValue(): int
    {
        return $this->id;
    }
}
