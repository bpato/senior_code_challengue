<?php

namespace App\Tests\Unit\Api\Cart\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\ValueObject\CartItemPrice;
use App\Api\Cart\Domain\Exception\InvalidArgumentException;

class CartItemPriceTest extends TestCase
{
    public function testCanCreateValidQuantity()
    {
        $cartItemPrice = new CartItemPrice(3.4);
        $this->assertEquals(3.4, $cartItemPrice->getValue());
    }

    public function testZeroCreateValidQuantity()
    {
        $cartItemPrice = new CartItemPrice(0);
        $this->assertEquals(0, $cartItemPrice->getValue());
    }

    public function testNegativeQuantityThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new CartItemPrice(-5);
    }
}
