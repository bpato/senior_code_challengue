<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Domain\ValueObject\Price;
use App\Api\Checkout\Domain\ValueObject\CartId;
use App\Api\Checkout\Domain\Entity\OrderProduct;
use App\Api\Checkout\Domain\ValueObject\OrderId;
use App\Api\Checkout\Domain\ValueObject\Quantity;
use App\Api\Checkout\Domain\ValueObject\OrderEmail;

class OrderTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testCanSetAndGetBasicFields()
    {
        $order = new Order();

        $orderId = new OrderId(1);
        $cartId = new CartId($this->faker->uuid());
        $email = new OrderEmail($this->faker->email());
        $createdAt = new \DateTimeImmutable();
        $price = new Price(123.45);
        $quantity = new Quantity(5);

        $order->setId($orderId)
              ->setCartReference($cartId)
              ->setEmail($email)
              ->setCreatedAt($createdAt)
              ->setTotalPrice($price)
              ->setTotalQuantity($quantity);

        $this->assertSame($orderId, $order->getId());
        $this->assertSame($cartId, $order->getCartReference());
        $this->assertSame($email, $order->getEmail());
        $this->assertSame($createdAt, $order->getCreatedAt());
        $this->assertSame($price, $order->getTotalPrice());
        $this->assertSame($quantity, $order->getTotalQuantity());
    }

    public function testAddOrderProductAndGetOrderProducts()
    {
        $order = new Order();

        $product1 = $this->createMock(OrderProduct::class);
        $product2 = $this->createMock(OrderProduct::class);

        $order->addOrderProduct($product1)
              ->addOrderProduct($product2);

        $products = iterator_to_array($order->getOrderProducts());

        $this->assertCount(2, $products);
        $this->assertSame($product1, $products[0]);
        $this->assertSame($product2, $products[1]);
    }

    public function testCalculateTotalPrice()
    {
        $order = new Order();

        $p1 = $this->createMock(OrderProduct::class);
        $p1->method('getTotalPrice')->willReturn(new Price(10.50));

        $p2 = $this->createMock(OrderProduct::class);
        $p2->method('getTotalPrice')->willReturn(new Price(20.00));

        $order->addOrderProduct($p1)
              ->addOrderProduct($p2);

        $order->calculateTotalPrice();

        $this->assertEquals(30.50, $order->getTotalPrice()->getValue());
    }

    public function testCalculateTotalQuantity()
    {
        $order = new Order();

        $p1 = $this->createMock(OrderProduct::class);
        $p1->method('getQuantity')->willReturn(new Quantity(2));

        $p2 = $this->createMock(OrderProduct::class);
        $p2->method('getQuantity')->willReturn(new Quantity(3));

        $order->addOrderProduct($p1)
              ->addOrderProduct($p2);

        $order->calculateTotalQuantity();

        $this->assertEquals(5, $order->getTotalQuantity()->getValue());
    }
}
