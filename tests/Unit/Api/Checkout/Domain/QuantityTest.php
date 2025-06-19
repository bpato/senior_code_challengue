<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\ValueObject\Quantity;
use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class QuantityTest extends TestCase
{
    public function testCanCreateValidQuantity()
    {
        $quantity = new Quantity(3);
        $this->assertEquals(3, $quantity->getValue());
    }

    public function testZeroQuantityThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Quantity(0);
    }

    public function testNegativeQuantityThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Quantity(-5);
    }
}
