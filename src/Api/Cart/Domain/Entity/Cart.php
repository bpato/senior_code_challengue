<?php

namespace App\Api\Cart\Domain\Entity;

use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;

/**
 * Cart
 */
class Cart
{

    /** @var CartItem[] */
    private array $items = [];

    public function __construct(private readonly CartId $id) {}

    /**
     * getId
     *
     * @return CartId
     */
    public function getId(): CartId
    {
        return $this->id;
    }

    /**
     * addItem
     *
     * @param  mixed $item
     * @return void
     */
    public function addItem(CartItem $item): void
    {
        foreach ($this->getItems() as $currentItem) {
            if ($currentItem->equals($item)) {
                $currentItem->setQuantity($item->getQuantity());
                return;
            }
        }

        $this->items[] = $item;
    }

    /**
     * getItems
     *
     * @return iterable
     */
    public function getItems(): iterable
    {
        foreach ($this->items as $item) {
            yield $item;
        }
    }

    /**
     * removeItemByProductId
     *
     * @param  mixed $productId
     * @return bool
     */
    public function removeItemByProductId(ProductId $productId): bool
    {
        foreach ($this->getItems() as $key => $currentItem) {
            if ($currentItem->getProductId()->equals($productId)) {
                unset($this->items[$key]);
                $this->items = array_values($this->items); // Reindex the array
                return true;
            }
        }

        return false;
    }

    /**
     * clear
     *
     * @return void
     */
    public function clear(): void
    {
        $this->items = [];
    }

    /**
     * updateQuantityByProductId
     *
     * @param  mixed $productId
     * @param  mixed $quantity
     * @return bool
     */
    public function updateQuantityByProductId(ProductId $productId, CartItemQuantity $quantity): bool
    {
        if ($quantity->getValue() <= 0) {
            return $this->removeItemByProductId($productId);
        }

        foreach ($this->getItems() as $item) {
            if ($item->getProductId()->equals($productId)) {
                $item->setQuantity($quantity);
                return true;
            }
        }

        $cartItem = new CartItem($productId, $quantity);
        $this->addItem($cartItem);
        return true;
    }

    /**
     * getTotalItems
     *
     * @return int
     */
    public function getTotalItems(): int
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->getQuantity()->getValue();
        }
        return $total;
    }
}
