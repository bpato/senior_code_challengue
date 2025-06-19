<?php
namespace App\Api\Checkout\Application\Dto;

use App\Api\Checkout\Domain\Entity\OrderProduct;
use Symfony\Component\ObjectMapper\Attribute\Map;
use App\Api\Checkout\Domain\Contract\Dto\OrderProductDtoInterface;

#[Map(target: OrderProduct::class)]
class OrderProductDto implements OrderProductDtoInterface
{
    #[Map(name: 'product_id')]
    public int $product_id;

    #[Map(name: 'name')]
    public string $name;

    #[Map(name: 'unit_price')]
    public float $unit_price;

    #[Map(name: 'total_price')]
    public float $total_price;

    #[Map(name: 'quantity')]
    public int $quantity;

    public function __construct(OrderProduct $orderProduct)
    {
        $this->product_id = $orderProduct->getProductId()->getValue();
        $this->name = $orderProduct->getName()->getValue();
        $this->unit_price = $orderProduct->getPrice()->getValue();
        $this->quantity = $orderProduct->getQuantity()->getValue();
        $this->total_price = $orderProduct->getTotalPrice()->getvalue();
    }
}
