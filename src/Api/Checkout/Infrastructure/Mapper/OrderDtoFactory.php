<?php

namespace App\Api\Checkout\Infrastructure\Mapper;

use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Application\Dto\OrderDto;
use App\Api\Checkout\Application\Dto\OrderProductDto;
use App\Api\Checkout\Domain\Contract\Dto\OrderDtoFactoryInterface;

final class OrderDtoFactory implements OrderDtoFactoryInterface
{
    public function create(Order $order): OrderDto
    {

        $orderDto = new OrderDto($order);

        foreach ($order->getOrderProducts() as $orderProduct ) {
            $orderProductDto = new OrderProductDto($orderProduct);
            $orderDto->addProduct($orderProductDto);
        }

        return $orderDto;
    }
}
