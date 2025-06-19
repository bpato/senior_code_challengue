<?php
namespace App\Api\Checkout\Application\UseCase;

use Symfony\Component\Messenger\HandleTrait;
use App\Api\Checkout\Application\Dto\OrderDto;
use App\Api\Checkout\Domain\ValueObject\OrderId;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Api\Checkout\Application\Query\GetOrderQuery;
use App\Api\Checkout\Domain\Contract\Dto\OrderDtoFactoryInterface;
use App\Api\Checkout\Domain\Contract\UseCase\GetOrderUseCaseInterface;
use App\Api\Checkout\Domain\Entity\Order;

class GetOrderUseCase implements GetOrderUseCaseInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus,
        private OrderDtoFactoryInterface $orderDtoFactory
    )
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke($id): OrderDto
    {

        $orderId = new OrderId($id);

        /** @var Order $order */
        $order = $this->handle(new GetOrderQuery($orderId));

        $orderDto = $this->orderDtoFactory->create($order);

        return $orderDto;
    }
}
