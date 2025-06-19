<?php

namespace App\Api\Checkout\Domain\ValueObject;

use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class OrderEmail
{

    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('Invalid email address: %s', $email));
        }

        $this->email = $email;
    }

    public function getValue(): string
    {
        return $this->email;
    }
}
