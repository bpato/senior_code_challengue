<?php

namespace App\Api\Checkout\Application\CommandHandler;

use App\Api\Checkout\Domain\ValueObject\OrderId;
use App\Api\Checkout\Application\Command\AddOrderCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Api\Checkout\Application\Exception\OrderNotSavedException;
use App\Api\Checkout\Domain\Contract\Repository\OrderRepositoryInterface;

#[AsMessageHandler]
class AddOrderHandler
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {
    }

    public function __invoke(AddOrderCommand $command): OrderId
    {

        $orderId = $this->orderRepository->save($command->getOrder());

        if (!$orderId->getValue())
        {
            throw new OrderNotSavedException();
        }

        return $orderId;
    }
}
