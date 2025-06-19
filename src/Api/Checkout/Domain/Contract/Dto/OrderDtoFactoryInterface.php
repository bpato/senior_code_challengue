<?php

namespace App\Api\Checkout\Domain\Contract\Dto;

use App\Api\Checkout\Domain\Entity\Order;

interface OrderDtoFactoryInterface
{
    public function create(Order $order): OrderDtoInterface;
}
