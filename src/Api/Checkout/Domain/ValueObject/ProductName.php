<?php

namespace App\Api\Checkout\Domain\ValueObject;

use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class ProductName
{

    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException(sprintf('Invalid product name: %s', $name));
        }

        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
