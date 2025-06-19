<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\ValueObject\OrderId;
use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class OrderIdTest extends TestCase
{
    public function testCanCreateValidQuantity()
    {
        $orderId = new OrderId(3);
        $this->assertEquals(3, $orderId->getValue());
    }

    public function testZeroThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new OrderId(0);
    }

    public function testNegativeQuantityThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new OrderId(-5);
    }
}
