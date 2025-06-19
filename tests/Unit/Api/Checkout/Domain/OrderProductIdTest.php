<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\ValueObject\OrderProductId;
use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class OrderProductIdTest extends TestCase
{
    public function testCanCreateValidQuantity()
    {
        $orderProductId = new OrderProductId(3);
        $this->assertEquals(3, $orderProductId->getValue());
    }

    public function testZeroThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new OrderProductId(0);
    }

    public function testNegativeQuantityThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new OrderProductId(-5);
    }
}
