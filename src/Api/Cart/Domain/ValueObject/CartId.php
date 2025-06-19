<?php

namespace App\Api\Cart\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;
use App\Api\Cart\Domain\Exception\InvalidArgumentException;

class CartId
{
    public const HEADER_KEY = 'X-Cart-Id';

    private string $id;

    public function __construct(?string $id = null)
    {
        if (empty($id)) {
            $id = Uuid::v4()->toString();
        }

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
