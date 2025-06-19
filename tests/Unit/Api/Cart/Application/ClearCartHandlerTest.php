<?php

namespace App\Tests\Unit\Api\Cart\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Application\Command\ClearCartCommand;
use App\Api\Cart\Application\CommandHandler\ClearCartHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

class ClearCartHandlerTest extends TestCase
{
    public function testInvokeClearsCartAndUpdatesIt()
    {
        $faker = Factory::create();
        $cartId = new CartId($faker->uuid());
        $command = new ClearCartCommand($cartId);

        $cart = $this->createMock(Cart::class);

        $cart->expects($this->once())
            ->method('clear');

        $cartRepository = $this->createMock(CartRepositoryInterface::class);

        $cartRepository->expects($this->once())
            ->method('findById')
            ->with($cartId)
            ->willReturn($cart);

        $cartRepository->expects($this->once())
            ->method('update')
            ->with($cart)
            ->willReturn($cart);

        $handler = new ClearCartHandler($cartRepository);

        $handler($command);
    }
}
