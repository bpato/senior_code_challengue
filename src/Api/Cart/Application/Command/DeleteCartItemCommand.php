<?php

namespace App\Api\Cart\Application\Command;

use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Domain\ValueObject\ProductId;

final class DeleteCartItemCommand
{
    public function __construct(
        public CartId $cartId,
        public ProductId $productId
    ) {
    }

    public function getCartId(): CartId {
        return $this->cartId;
    }

    public function getProductId(): ProductId {
        return $this->productId;
    }

    public function toArray(): array {
        return [
            'cart_id' => $this->cartId->getValue(),
            'product_id' => $this->productId->getValue(),
        ];
    }
}
