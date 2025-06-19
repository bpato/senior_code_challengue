<?php

namespace App\Api\Cart\Application\Dto;

use App\Api\Cart\Domain\Entity\Cart;
use Symfony\Component\ObjectMapper\Attribute\Map;
use App\Api\Cart\Domain\Contract\Dto\CartDtoInterface;

#[Map(target: Cart::class)]
class CartDto implements CartDtoInterface
{
    #[Map(name: 'id')]
    public ?string $id = null;

    #[Map(name: 'items')]
    public array $items = [];

    #[Map(name: 'total_items')]
    public int $total_items;

    #[Map(name: 'total_price')]
    public float $total_price;

    public function __construct(Cart $cart)
    {
        $this->id = $cart->getId()->getValue();
        $this->total_items = $cart->getTotalItems();
    }

    public function addItem(CartItemDto $item): void
    {
        $this->items[] = $item;
    }

    public function setTotalPrice(float $total_price): void
    {
        $this->total_price = $total_price;
    }
}
