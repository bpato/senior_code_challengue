<?php

namespace App\Tests\Unit\Api\Checkout\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Domain\ValueObject\OrderId;
use App\Api\Checkout\Application\Query\GetOrderQuery;
use App\Api\Checkout\Application\QueryHandler\GetOrderHandler;
use App\Api\Checkout\Domain\Contract\Repository\OrderRepositoryInterface;

class GetOrderHandlerTest extends TestCase
{
    public function testInvokeReturnsOrder()
    {

        $orderId = new OrderId(1);
        $query = new GetOrderQuery($orderId);
        $expectedOrder = $this->createMock(Order::class);

        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $orderRepository->expects($this->once())
            ->method('findById')
            ->with($orderId)
            ->willReturn($expectedOrder);

        $handler = new GetOrderHandler($orderRepository);

        $result = $handler($query);

        $this->assertSame($expectedOrder, $result);
    }
}
