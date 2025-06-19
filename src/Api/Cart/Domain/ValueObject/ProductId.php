<?php

namespace App\Api\Cart\Domain\ValueObject;

use App\Api\Cart\Domain\Exception\InvalidArgumentException;

class ProductId
{
    private int $id;

    public function __construct(int $id)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('ProductId must be a positive integer');
        }

        $this->id = $id;
    }

    public function getValue(): int
    {
        return $this->id;
    }

    public function equals(ProductId $other): bool
    {
        return $this->id === $other->getValue();
    }
}
