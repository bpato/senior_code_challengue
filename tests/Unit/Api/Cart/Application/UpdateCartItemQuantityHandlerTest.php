<?php

namespace App\Tests\Unit\Api\Cart\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;
use App\Api\Cart\Application\Command\UpdateCartItemQuantityCommand;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;
use App\Api\Cart\Application\CommandHandler\UpdateCartItemQuantityHandler;

class UpdateCartItemQuantityHandlerTest extends TestCase
{
    public function testInvokeUpdatesQuantityAndSavesCart()
    {
        $faker = Factory::create();

        $cartId = new CartId($faker->uuid());
        $productId = new ProductId(1);
        $quantity = new CartItemQuantity(5);

        $command = new UpdateCartItemQuantityCommand($cartId, $productId, $quantity);

        $cart = $this->createMock(Cart::class);

        // Esperamos que el carrito actualice la cantidad del producto
        $cart->expects($this->once())
            ->method('updateQuantityByProductId')
            ->with($productId, $quantity)
            ->willReturn(true);

        $cartRepository = $this->createMock(CartRepositoryInterface::class);

        $cartRepository->expects($this->once())
            ->method('findById')
            ->with($cartId)
            ->willReturn($cart);

        $cartRepository->expects($this->once())
            ->method('update')
            ->with($cart)
            ->willReturn($cart);

        $handler = new UpdateCartItemQuantityHandler($cartRepository);

        $handler($command);
    }
}
