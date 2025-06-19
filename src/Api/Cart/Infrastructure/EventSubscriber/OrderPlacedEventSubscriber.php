<?php
namespace App\Api\Cart\Infrastructure\EventSubscriber;

use App\Api\Cart\Domain\ValueObject\CartId;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Api\Cart\Application\Command\DeleteCartCommand;
use App\Api\Checkout\Application\Event\OnOrderPlacedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class OrderPlacedEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private MessageBusInterface $commandBus)
    {

    }

    public static function getSubscribedEvents(): array
    {
        return [
            OnOrderPlacedEvent::class => 'cartDelete'
        ];
    }

    public function cartDelete(OnOrderPlacedEvent $event)
    {
        $cartId = new CartId($event->getOrder()->getCartReference()->getValue());

        $this->commandBus->dispatch(new DeleteCartCommand($cartId));
    }

}
