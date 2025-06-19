<?php

namespace App\Api\Cart\Application\Command;

use App\Api\Cart\Domain\ValueObject\CartId;

final class AddCartCommand {
    private CartId $cartId;

    public function __construct(CartId $cartId)
    {
        $this->cartId = $cartId;
    }

    public function getCartId(): CartId
    {
        return $this->cartId;
    }
}
