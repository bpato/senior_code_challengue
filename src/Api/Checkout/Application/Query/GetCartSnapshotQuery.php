<?php

namespace App\Api\Checkout\Application\Query;

use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Checkout\Domain\ValueObject\CartId as CheckoutCartId;

final class GetCartSnapshotQuery {

    public function __construct(private CheckoutCartId $cartId)
    {
    }

    public function getCartId(): CartId
    {
        return new CartId($this->cartId->getValue());
    }

}
