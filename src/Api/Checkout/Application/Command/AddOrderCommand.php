<?php

namespace App\Api\Checkout\Application\Command;

use App\Api\Checkout\Domain\Entity\Order;

final class AddOrderCommand {
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
