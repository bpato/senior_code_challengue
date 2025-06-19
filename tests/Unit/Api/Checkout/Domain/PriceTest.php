<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\ValueObject\Price;
use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class PriceTest extends TestCase
{
    public function testCanCreateValidQuantity()
    {
        $price = new Price(3.4);
        $this->assertEquals(3.4, $price->getValue());
    }

    public function testZeroCreateValidQuantity()
    {
        $price = new Price(0);
        $this->assertEquals(0, $price->getValue());
    }

    public function testNegativeQuantityThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Price(-5);
    }
}
