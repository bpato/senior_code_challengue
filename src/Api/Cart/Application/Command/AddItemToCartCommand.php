<?php

namespace App\Api\Cart\Application\Command;

use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;

final class AddItemToCartCommand
{
    public function __construct(
        public CartId $cartId,
        public ProductId $productId,
        public CartItemQuantity $cartItemQuantity
    ) {
    }

    public function getCartId(): CartId {
        return $this->cartId;
    }

    public function getProductId(): ProductId {
        return $this->productId;
    }

    public function getCartItemQuantity(): CartItemQuantity {
        return $this->cartItemQuantity;
    }

    public function toArray(): array {
        return [
            'cart_id' => $this->cartId->getValue(),
            'product_id' => $this->productId->getValue(),
            'quantity' => $this->cartItemQuantity->getValue(),
        ];
    }
}
