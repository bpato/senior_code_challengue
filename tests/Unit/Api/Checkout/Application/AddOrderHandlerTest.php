<?php

namespace App\Tests\Unit\Api\Checkout\Application;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Domain\ValueObject\OrderId;
use App\Api\Checkout\Application\Command\AddOrderCommand;
use App\Api\Checkout\Application\CommandHandler\AddOrderHandler;
use App\Api\Checkout\Domain\Contract\Repository\OrderRepositoryInterface;

class AddOrderHandlerTest extends TestCase
{
    public function testInvokeAddsOrderAndReturnsOrderId()
    {
        $faker = Factory::create();

        $orderId = new OrderId(1);

        $command = new AddOrderCommand(new Order());

        $orderRepository = $this->createMock(OrderRepositoryInterface::class);

        $orderRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Order::class))
            ->willReturn($orderId);

        $handler = new AddOrderHandler($orderRepository);

        $result = $handler($command);

        $this->assertInstanceOf(OrderId::class, $result);
        $this->assertEquals($orderId, $result);
    }
}
