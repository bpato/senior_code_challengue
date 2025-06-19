<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\ValueObject\Price;
use App\Api\Checkout\Domain\Entity\OrderProduct;
use App\Api\Checkout\Domain\ValueObject\Quantity;
use App\Api\Checkout\Domain\ValueObject\ProductId;
use App\Api\Checkout\Domain\ValueObject\ProductName;
use App\Api\Checkout\Domain\ValueObject\OrderProductId;

class OrderProductTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testCanSetAndGetFields()
    {
        $orderProduct = new OrderProduct();

        $id = new OrderProductId(1);
        $name = new ProductName($this->faker->words(2, true));
        $price = new Price(9.99);
        $quantity = new Quantity(3);
        $productId = new ProductId(12);
        $totalPrice = new Price(29.97);

        $orderProduct->setId($id)
            ->setName($name)
            ->setPrice($price)
            ->setQuantity($quantity)
            ->setProductId($productId)
            ->setTotalPrice($totalPrice);

        $this->assertSame($id, $orderProduct->getId());
        $this->assertSame($name, $orderProduct->getName());
        $this->assertSame($price, $orderProduct->getPrice());
        $this->assertSame($quantity, $orderProduct->getQuantity());
        $this->assertSame($productId, $orderProduct->getProductId());
        $this->assertSame($totalPrice, $orderProduct->getTotalPrice());
    }

    public function testCalculateTotalPrice()
    {
        $orderProduct = new OrderProduct();

        $price = new Price(15.00);
        $quantity = new Quantity(2);
        $expectedTotal = new Price(30.00);

        $orderProduct->setPrice($price)
            ->setQuantity($quantity);

        $orderProduct->calculateTotalPrice();

        $this->assertEquals($expectedTotal->getValue(), $orderProduct->getTotalPrice()->getValue());
    }
}
