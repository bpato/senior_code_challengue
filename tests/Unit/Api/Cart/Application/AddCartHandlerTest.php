<?php

namespace App\Tests\Unit\Api\Cart\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Application\Command\AddCartCommand;
use App\Api\Cart\Application\CommandHandler\AddCartHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

class AddCartHandlerTest extends TestCase
{
    public function testInvokeSavesNewCart()
    {
        $faker = Factory::create();
        $cartId = new CartId($faker->uuid());

        $command = new AddCartCommand($cartId);

        $cartRepository = $this->createMock(CartRepositoryInterface::class);

        $cartRepository->expects($this->once())
            ->method('save')
            ->with($this->callback(function ($cart) use ($cartId) {
                return $cart instanceof Cart && $cart->getId()->getValue() === $cartId->getValue();
            }))
            ->willReturn($cartId);

        $handler = new AddCartHandler($cartRepository);

        $handler($command);
    }
}
