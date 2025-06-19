<?php

namespace App\Tests\Unit\Api\Cart\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Application\Command\DeleteCartItemCommand;
use App\Api\Cart\Application\CommandHandler\DeleteCartItemHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

class DeleteCartItemHandlerTest extends TestCase
{
    public function testInvokeRemovesItemAndUpdatesCart()
    {
        $faker = Factory::create();
        $cartId = new CartId($faker->uuid());
        $productId = new ProductId(1);

        $command = new DeleteCartItemCommand($cartId, $productId);

        $cart = $this->createMock(Cart::class);

        // Se espera que se llame a removeItemByProductId con el ProductId
        $cart->expects($this->once())
            ->method('removeItemByProductId')
            ->with($productId)
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

        $handler = new DeleteCartItemHandler($cartRepository);

        $handler($command);
    }
}
