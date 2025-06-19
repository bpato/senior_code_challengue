<?php

namespace App\Api\Checkout\Application\Query;

use App\Api\Checkout\Domain\ValueObject\OrderId;


final class GetOrderQuery {

    public function __construct(private OrderId $orderId)
    {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

}
