<?php

namespace App\Api\Checkout\Domain\Contract\Dto;

use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Cart\Application\Dto\CartSnapshot;
use App\Api\Checkout\Domain\ValueObject\OrderEmail;

interface OrderFactoryInterface
{
    public function forCustomer(OrderEmail $email): self;
    public function createFrom(CartSnapshot $cart): self;
    public function get(): Order;
}
