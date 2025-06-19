<?php

namespace App\Api\Checkout\Application\UseCase;

use App\Api\Checkout\Domain\Entity\Order;
use Symfony\Component\Messenger\HandleTrait;
use App\Api\Cart\Application\Dto\CartSnapshot;
use App\Api\Checkout\Application\Dto\OrderDto;
use App\Api\Checkout\Domain\ValueObject\CartId;
use Psr\EventDispatcher\EventDispatcherInterface;
use App\Api\Checkout\Domain\ValueObject\ProductId;
use App\Api\Checkout\Domain\ValueObject\OrderEmail;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Api\Checkout\Application\Query\GetOrderQuery;
use App\Api\Checkout\Domain\ValueObject\OrderProductId;
use App\Api\Checkout\Application\Command\AddOrderCommand;
use App\Api\Checkout\Application\Event\OnOrderPlacedEvent;
use App\Api\Checkout\Application\Query\GetCartSnapshotQuery;
use App\Api\Checkout\Domain\Contract\Dto\OrderFactoryInterface;
use App\Api\Checkout\Domain\Contract\Dto\OrderDtoFactoryInterface;
use App\Api\Checkout\Application\Exception\ProductNotFoundException;
use App\Api\Checkout\Domain\Contract\UseCase\CreateOrderUseCaseInterface;
use App\Api\Checkout\Domain\Contract\Repository\ProductRepositoryInterface;


class CreateOrderUseCase implements CreateOrderUseCaseInterface
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $commandBus,
        MessageBusInterface $queryBus,
        private EventDispatcherInterface $eventDispatcher,
        private ProductRepositoryInterface $productRepository,
        private OrderFactoryInterface $orderFactory,
        private OrderDtoFactoryInterface $orderDtoFactory
    )
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(?array $payload = null): OrderDto
    {

        $cartId = new CartId($payload['cart_id']);

         /** @var CartSnapshot $cart */
        $cart = $this->handle(new GetCartSnapshotQuery($cartId));

        $orderEmail = new OrderEmail($payload['email']);

        foreach ($cart->getItems() as $item) {
            $productId = new ProductId($item->product_id);
            if (! $this->productRepository->findById($productId)) {
                // lanzar evento borrar item
                throw new ProductNotFoundException($productId);
            }
        }

        $newOrder = $this->orderFactory->forCustomer($orderEmail)
                        ->createFrom($cart)
                        ->get();



        $orderId = $this->handle(new AddOrderCommand($newOrder));

        /** @var Order $order */
        $order = $this->handle(new GetOrderQuery($orderId));

        $this->eventDispatcher->dispatch(
            new OnOrderPlacedEvent($order)
        );

        $orderDto = $this->orderDtoFactory->create($order);

        return $orderDto;
    }
}
