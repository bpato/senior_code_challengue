<?php

namespace App\Tests\Unit\Api\Cart\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Application\Command\DeleteCartCommand;
use App\Api\Cart\Application\CommandHandler\DeleteCartHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

class DeleteCartHandlerTest extends TestCase
{
    public function testInvokeFindsCart()
    {
        $faker = Factory::create();
        $cartId = new CartId($faker->uuid());
        $command = new DeleteCartCommand($cartId);

        $cart = $this->createMock(Cart::class);

        $cartRepository = $this->createMock(CartRepositoryInterface::class);

        $cartRepository->expects($this->once())
            ->method('findById')
            ->with($cartId)
            ->willReturn($cart);

        $cartRepository->expects($this->once())
            ->method('delete')
            ->with($cart);

        $handler = new DeleteCartHandler($cartRepository);

        $handler($command);
    }
}
