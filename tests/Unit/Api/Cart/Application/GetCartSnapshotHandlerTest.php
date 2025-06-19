<?php

namespace App\Tests\Unit\Api\Cart\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Application\Dto\CartSnapshot;
use App\Api\Checkout\Application\Query\GetCartSnapshotQuery;
use App\Api\Cart\Application\QueryHandler\GetCartSnapshotHandler;
use App\Api\Checkout\Domain\ValueObject\CartId as CheckoutCartId;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

class GetCartSnapshotHandlerTest extends TestCase
{
    public function testInvokeReturnsCartSnapshot()
    {
        $faker = Factory::create();

        $cartId = new CartId($faker->uuid());
        $checkoutCartId = new CheckoutCartId($cartId->getValue());
        $query = new GetCartSnapshotQuery($checkoutCartId);

        $cartRepository = $this->createMock(CartRepositoryInterface::class);

        $cartRepository->expects($this->once())
            ->method('findById')
            ->with($cartId)
            ->willReturn(new Cart($cartId));

        $handler = new GetCartSnapshotHandler($cartRepository);

        $result = $handler($query);

        $this->assertInstanceOf(CartSnapshot::class, $result);
    }
}
