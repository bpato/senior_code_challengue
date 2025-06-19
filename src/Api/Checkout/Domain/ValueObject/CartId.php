<?php

namespace App\Api\Checkout\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;
use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class CartId
{

    private string $id;

    public function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('Invalid Cart ID: %s', $id));
        }

        $this->id = $id;
    }

    public function getValue(): string
    {
        return $this->id;
    }
}
