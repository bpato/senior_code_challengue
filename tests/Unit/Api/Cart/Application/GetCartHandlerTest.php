<?php

namespace App\Tests\Unit\Api\Cart\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Application\Query\GetCartQuery;
use App\Api\Cart\Application\QueryHandler\GetCartHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

class GetCartHandlerTest extends TestCase
{
    public function testInvokeReturnsCart()
    {
        $faker = Factory::create();

        $cartId = new CartId($faker->uuid());
        $query = new GetCartQuery($cartId);

        $expectedCart = $this->createMock(Cart::class);

        $cartRepository = $this->createMock(CartRepositoryInterface::class);

        $cartRepository->expects($this->once())
            ->method('findById')
            ->with($cartId)
            ->willReturn($expectedCart);

        $handler = new GetCartHandler($cartRepository);

        $result = $handler($query);

        $this->assertSame($expectedCart, $result);
    }
}
