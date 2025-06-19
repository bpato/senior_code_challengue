<?php

namespace App\Tests\Unit\Api\Checkout\Infraestructure;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\Entity\Order;
use Symfony\Component\Messenger\Envelope;
use App\Api\Cart\Domain\ValueObject\CartId;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Api\Cart\Application\Command\DeleteCartCommand;
use App\Api\Checkout\Application\Event\OnOrderPlacedEvent;
use App\Api\Cart\Infrastructure\EventSubscriber\OrderPlacedEventSubscriber;

class OrderPlacedEventSubscriberTest extends TestCase
{
    public function testOnOrderPlacedEventContainsOrder()
    {
        $order = $this->createMock(Order::class);

        $event = new OnOrderPlacedEvent($order);

        $this->assertSame($order, $event->getOrder());
    }

    public function testCartDeleteDispatchesDeleteCartCommand()
    {
        $faker = Factory::create('es_ES');

        $busMock = $this->createMock(MessageBusInterface::class);

        $busMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function($command) {
                return $command instanceof DeleteCartCommand;
            }))
            ->willReturn(new Envelope(new DeleteCartCommand(new CartId($faker->uuid()))));


        $subscriber = new OrderPlacedEventSubscriber($busMock);

        $orderMock = $this->createMock(Order::class);
        $event = new OnOrderPlacedEvent($orderMock);

        $subscriber->cartDelete($event);
    }
}
