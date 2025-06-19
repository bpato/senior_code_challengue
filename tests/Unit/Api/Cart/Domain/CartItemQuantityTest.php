<?php

namespace App\Tests\Unit\Api\Cart\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;
use App\Api\Cart\Domain\Exception\InvalidArgumentException;

class CartItemQuantityTest extends TestCase
{
    public function testCanCreateValidQuantity()
    {
        $quantity = new CartItemQuantity(3);
        $this->assertEquals(3, $quantity->getValue());
    }

    public function testZeroCreateValidQuantity()
    {
        $quantity = new CartItemQuantity(0);
        $this->assertEquals(0, $quantity->getValue());
    }

    public function testNegativeQuantityThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new CartItemQuantity(-5);
    }
}
