<?php

namespace App\Tests\Unit\Api\Cart\Domain;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\Entity\CartItem;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;

class CartTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
    }

    public function testGetIdReturnsCartId()
    {
        $cartId = new CartId($this->faker->uuid());
        $cart = new Cart($cartId);

        $this->assertSame($cartId, $cart->getId());
    }

    public function testAddItemAndGetItems()
    {
        $cartId = new CartId($this->faker->uuid());
        $cart = new Cart($cartId);

        $productId = new ProductId(1);
        $quantity = new CartItemQuantity(2);
        $item = new CartItem($productId, $quantity);

        $cart->addItem($item);

        $items = iterator_to_array($cart->getItems());
        $this->assertCount(1, $items);
        $this->assertSame($item, $items[0]);
    }

    public function testRemoveItemByProductId()
    {
        $cart = new Cart(new CartId($this->faker->uuid()));

        $productId = new ProductId(1);
        $item = new CartItem($productId, new CartItemQuantity(1));
        $cart->addItem($item);

        $result = $cart->removeItemByProductId($productId);
        $this->assertTrue($result);
        $this->assertCount(0, iterator_to_array($cart->getItems()));
    }

    public function testRemoveItemByProductIdReturnsFalseIfNotFound()
    {
        $cart = new Cart(new CartId($this->faker->uuid()));
        $result = $cart->removeItemByProductId(new ProductId(1));
        $this->assertFalse($result);
    }

    public function testClearEmptiesTheCart()
    {
        $cart = new Cart(new CartId($this->faker->uuid()));

        $cart->addItem(new CartItem(new ProductId(1), new CartItemQuantity(1)));
        $cart->addItem(new CartItem(new ProductId(2), new CartItemQuantity(1)));

        $cart->clear();
        $this->assertCount(0, iterator_to_array($cart->getItems()));
    }

    public function testUpdateQuantityByProductId()
    {
        $cart = new Cart(new CartId($this->faker->uuid()));

        $productId = new ProductId(1);
        $cart->addItem(new CartItem($productId, new CartItemQuantity(1)));

        $result = $cart->updateQuantityByProductId($productId, new CartItemQuantity(5));
        $this->assertTrue($result);

        $items = iterator_to_array($cart->getItems());
        $this->assertEquals(5, $items[0]->getQuantity()->getValue());
    }

    public function testUpdateQuantityByProductIdAddTheProductIfNotFound()
    {
        $cart = new Cart(new CartId($this->faker->uuid()));
        $result = $cart->updateQuantityByProductId(new ProductId(1), new CartItemQuantity(3));
        $this->assertTrue($result);
        $items = iterator_to_array($cart->getItems());
        $this->assertCount(1, $items);
        $this->assertEquals(3, $items[0]->getQuantity()->getValue());
    }

    public function testUpdateQuantityByProductIdAddQuantityZeroRemoveTheItem()
    {
        $cart = new Cart(new CartId($this->faker->uuid()));
        $result = $cart->updateQuantityByProductId(new ProductId(1), new CartItemQuantity(5));
        $this->assertTrue($result);
        $items = iterator_to_array($cart->getItems());
        $this->assertCount(1, $items);
        $this->assertEquals(5, $items[0]->getQuantity()->getValue());
        $result = $cart->updateQuantityByProductId(new ProductId(1), new CartItemQuantity(0));
        $items = iterator_to_array($cart->getItems());
        $this->assertCount(0, $items);
    }

    public function testGetTotalItems()
    {
        $cart = new Cart(new CartId($this->faker->uuid()));

        $cart->addItem(new CartItem(new ProductId(1), new CartItemQuantity(2)));
        $cart->addItem(new CartItem(new ProductId(2), new CartItemQuantity(3)));

        $this->assertEquals(5, $cart->getTotalItems());
    }

}
