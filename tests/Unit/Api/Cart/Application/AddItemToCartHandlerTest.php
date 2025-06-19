<?php

namespace App\Tests\Unit\Api\Cart\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\Entity\CartItem;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;
use App\Api\Cart\Application\Command\AddItemToCartCommand;
use App\Api\Cart\Application\CommandHandler\AddItemToCartHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

class AddItemToCartHandlerTest extends TestCase
{
    public function testInvokeFindsCartAndUpdatesIt()
    {
        $faker = Factory::create();

        $cartId = new CartId($faker->uuid());
        $productId = new ProductId(1);
        $quantity = new CartItemQuantity(2);

        $command = new AddItemToCartCommand($cartId, $productId, $quantity);

        $existingCart = $this->createMock(Cart::class);

        // Esperamos que el carrito reciba addItem
        $existingCart->expects($this->once())
            ->method('addItem')
            ->with($this->callback(fn($item) => $item instanceof CartItem));

        $cartRepository = $this->createMock(CartRepositoryInterface::class);

        $cartRepository->expects($this->once())
            ->method('findById')
            ->with($cartId)
            ->willReturn($existingCart);

        $cartRepository->expects($this->once())
            ->method('update')
            ->with($existingCart)
            ->willReturn($existingCart);

        $handler = new AddItemToCartHandler($cartRepository);

        $handler($command);
    }
}
