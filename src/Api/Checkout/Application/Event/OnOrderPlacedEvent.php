<?php

namespace App\Api\Checkout\Application\Event;

use App\Api\Checkout\Domain\Entity\Order;
use Symfony\Contracts\EventDispatcher\Event;

final class OnOrderPlacedEvent extends Event
{
    public const ORDER_PLACED = 'order.placed';

    public function __construct(private readonly Order $order)
    {}

    public function getOrder(): Order
    {
        return $this->order;
    }
}
