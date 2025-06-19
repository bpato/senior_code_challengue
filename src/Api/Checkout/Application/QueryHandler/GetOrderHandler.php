<?php

namespace App\Api\Checkout\Application\QueryHandler;

use App\Api\Checkout\Application\Query\GetOrderQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Api\Checkout\Domain\Contract\Repository\OrderRepositoryInterface;
use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Domain\Exception\OrderNotFoundException;

#[AsMessageHandler]
final class GetOrderHandler
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
    )
    {
    }

    public function __invoke(GetOrderQuery $query): Order
    {
        $orderId = $query->getOrderId();

        if( ! $order = $this->orderRepository->findById($orderId)) {
            throw new OrderNotFoundException($orderId);
        }

        return $order;
    }
}
