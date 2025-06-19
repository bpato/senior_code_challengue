<?php
namespace App\Api\Checkout\Application\Dto;

use DateTimeImmutable;
use DateTimeInterface;
use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Domain\ValueObject\Price;
use App\Api\Checkout\Domain\ValueObject\OrderId;
use App\Api\Checkout\Domain\ValueObject\Quantity;
use Symfony\Component\ObjectMapper\Attribute\Map;
use App\Api\Checkout\Domain\ValueObject\OrderEmail;
use App\Api\Checkout\Domain\Contract\Dto\OrderDtoInterface;

#[Map(target: Order::class)]
class OrderDto implements OrderDtoInterface
{
    #[Map(name: 'id')]
    public string $id;

    #[Map(name: 'cart_reference')]
    public string $cart_reference;

    #[Map(name: 'email')]
    public string $email;

    #[Map(name: 'total_price')]
    public float $total_price;

    #[Map(name: 'total_items')]
    public int $total_items;

    #[Map(name: 'created_at')]
    public string $created_at;

    #[Map(name: 'products')]
    public array $products = [];

    public function __construct(Order $order)
    {
        $this->id = $order->getId()->getValue();
        $this->cart_reference = $order->getCartReference()->getValue();
        $this->email = $order->getEmail()->getValue();
        $this->total_price = $order->getTotalPrice()->getValue();
        $this->total_items = $order->getTotalQuantity()->getValue();
        $this->created_at = $order->getCreatedAt()->format(DateTimeInterface::ATOM);
    }

    public function addProduct(OrderProductDto $product): void
    {
        $this->products[] = $product;
    }
}
