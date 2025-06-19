<?php

namespace App\Api\Cart\Application\Query;

use App\Api\Cart\Domain\ValueObject\CartId;

final class GetCartQuery {

    public function __construct(private CartId $cartId)
    {
    }

    public function getCartId(): CartId
    {
        return $this->cartId;
    }

}
