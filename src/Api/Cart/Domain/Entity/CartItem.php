<?php

namespace App\Api\Cart\Domain\Entity;

use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Domain\ValueObject\CartItemPrice;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;

class CartItem {
    public function __construct(
        private readonly ProductId $productId,
        private CartItemQuantity $quantity
    ) {
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getQuantity(): CartItemQuantity
    {
        return $this->quantity;
    }

    public function setQuantity(CartItemQuantity $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function equals(CartItem $other): bool
    {
        return $this->productId->getValue() === $other->getProductId()->getValue();
    }

}
