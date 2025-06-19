<?php

namespace App\Tests\Unit\Api\Cart\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\CartItem;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;

class CartItemTest extends TestCase
{
    public function testGetProductIdReturnsProductId()
    {
        $productId = new ProductId(1);
        $quantity = new CartItemQuantity(1);

        $cartItem = new CartItem($productId, $quantity);

        $this->assertSame($productId, $cartItem->getProductId());
    }

    public function testGetQuantityReturnsQuantity()
    {
        $productId = new ProductId(1);
        $quantity = new CartItemQuantity(5);

        $cartItem = new CartItem($productId, $quantity);

        $this->assertSame($quantity, $cartItem->getQuantity());
    }

    public function testSetQuantityReturnsQuantity()
    {
        $productId = new ProductId(1);
        $quantity = new CartItemQuantity(5);

        $cartItem = new CartItem($productId, $quantity);

        $this->assertSame($quantity, $cartItem->getQuantity());
        $this->assertEquals(5, $cartItem->getQuantity()->getValue());

        $quantity = new CartItemQuantity(10);
        $cartItem->setQuantity($quantity);
        $this->assertSame($quantity, $cartItem->getQuantity());
        $this->assertEquals(10, $cartItem->getQuantity()->getValue());
    }

    public function testCompareEquals()
    {
        $productId = new ProductId(1);
        $quantity = new CartItemQuantity(1);

        $cartItem = new CartItem($productId, $quantity);

        $this->assertTrue($cartItem->equals(new CartItem(
            new ProductId(1), new CartItemQuantity(1)
        )));
        $this->assertFalse($cartItem->equals(new CartItem(
            new ProductId(5), new CartItemQuantity(1)
        )));

    }
}
