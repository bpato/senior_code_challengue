<?php

namespace App\Api\Cart\Application\Dto;

use App\Api\Cart\Domain\Entity\CartItem;
use App\Api\Cart\Domain\ValueObject\ProductId;
use Symfony\Component\ObjectMapper\Attribute\Map;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;
use App\Api\Cart\Domain\Contract\Dto\CartItemDtoInterface;

#[Map(target: CartItem::class)]
class CartItemDto implements CartItemDtoInterface
{

    #[Map(name: 'product_id')]
    public int $product_id;

    #[Map(name: 'quantity')]
    public int $quantity;

    #[Map(name: 'name')]
    public string $name;

    #[Map(name: 'unit_price')]
    public float $unit_price;

    #[Map(name: 'price')]
    public float $price;

    public function __construct(
        ProductId $productId,
        string $name,
        CartItemQuantity $quantity,
        float $unit_price)
    {
        $this->product_id = $productId->getValue();
        $this->name = $name;
        $this->quantity = $quantity->getValue();
        $this->unit_price = $unit_price;
        $this->price = $unit_price * $quantity->getValue();
    }
}
